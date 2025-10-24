<!DOCTYPE html>
<html>
<head>
    <title>AQI Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #333; }
        .aqi-box { border: 1px solid #ccc; padding: 20px; border-radius: 10px; width: 400px; }
        .good { color: green; }
        .moderate { color: orange; }
        .unhealthy { color: red; }
    </style>
</head>
<body>
    <h1>AQI Display</h1>

    @if ($data)
        <div class="aqi-box">
            <h2>INSTANT AQI: {{ $data['overall']['instant'] }}</h2>
            <h2>NOWCAST AQI: {{ $data['overall']['nowcast'] }}</h2>

            <h3>Pollutant Breakdown:</h3>
            <ul>
                @foreach ($data['pollutants'] as $pollutant => $values)
                    <li>
                        <strong>{{ strtoupper($pollutant) }}</strong> → 
                        Instant: {{ $values['instant'] }}, 
                        NowCast: {{ $values['nowcast'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <p>No AQI data available.</p>
    @endif
</body>
</html>
