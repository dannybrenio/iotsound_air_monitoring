<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Hardware_data; // or HardwareData if that's your model name

class AqiCalculator
{
    private $breakpoints = [
        'pm2_5' => [
            [0, 12, 0, 50],
            [12.1, 35.4, 51, 100],
            [35.5, 55.4, 101, 150],
            [55.5, 150.4, 151, 200],
            [150.5, 250.4, 201, 300],
            [250.5, 350.4, 301, 400],
            [350.5, 500.4, 401, 500],
        ],
        'pm10' => [
            [0, 54, 0, 50],
            [55, 154, 51, 100],
            [155, 254, 101, 150],
            [255, 354, 151, 200],
            [355, 424, 201, 300],
            [425, 504, 301, 400],
            [505, 604, 401, 500],
        ],
        'no2' => [
            [0, 53, 0, 50],
            [54, 100, 51, 100],
            [101, 360, 101, 150],
            [361, 649, 151, 200],
            [650, 1249, 201, 300],
            [1250, 1649, 301, 400],
            [1650, 2049, 401, 500],
        ],
        'co' => [
            [0, 4.4, 0, 50],
            [4.5, 9.4, 51, 100],
            [9.5, 12.4, 101, 150],
            [12.5, 15.4, 151, 200],
            [15.5, 30.4, 201, 300],
            [30.5, 40.4, 301, 400],
            [40.5, 50.4, 401, 500],
        ],
    ];

    public function compute()
    {
        $readings = Hardware_data::latest('realtime_stamp')
            ->take(144)
            ->get()
            ->reverse();

        if ($readings->isEmpty()) {
            return null;
        }

        $pollutants = ['pm2_5', 'pm10', 'no2', 'co'];
        $aqiValues = [];

        foreach ($pollutants as $pollutant) {
            $values = $readings->pluck($pollutant)->filter()->values()->toArray();
            if (empty($values)) {
                continue;
            }

            $instantAqi = $this->calculateAqi($pollutant, end($values));

            $nowcastValue = $this->computeNowcast($values);
            $nowcastAqi = $this->calculateAqi($pollutant, $nowcastValue);

            $aqiValues[$pollutant] = [
                'instant' => round($instantAqi),
                'nowcast' => round($nowcastAqi),
            ];
        }

        $overallInstant = max(array_column($aqiValues, 'instant'));
        $overallNowcast = max(array_column($aqiValues, 'nowcast'));

        // return response()->json([
        //     'pollutants' => $aqiValues,
        //     'overall' => [
        //         'instant' => $overallInstant,
        //         'nowcast' => $overallNowcast,
        //     ],
        // ]);

        return [
            'pollutants' => $aqiValues,
            'overall' => [
                'instant' => $overallInstant,
                'nowcast' => $overallNowcast,
            ],
        ];


    }

    private function calculateAqi($pollutant, $concentration)
    {
        foreach ($this->breakpoints[$pollutant] as [$C_low, $C_high, $I_low, $I_high]) {
            if ($concentration >= $C_low && $concentration <= $C_high) {
                return (($I_high - $I_low) / ($C_high - $C_low))
                    * ($concentration - $C_low) + $I_low;
            }
        }
        return null;
    }

    private function computeNowcast(array $values)
    {
        if (count($values) < 2) {
            return end($values);
        }

        $min = min($values);
        $max = max($values);
        $w = max(0.5, $min / $max);

        $n = count($values);
        $sumWeights = 0;
        $sumWeightedValues = 0;

        for ($i = 0; $i < $n; $i++) {
            $weight = pow($w, $n - 1 - $i);
            $sumWeights += $weight;
            $sumWeightedValues += $values[$i] * $weight;
        }

        return $sumWeightedValues / $sumWeights;
    }
}

?> 
