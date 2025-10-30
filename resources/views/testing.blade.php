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
             @if ($individualdata)
    <ul>
        RAW DATA:
        {{$data['pollutants']['pm2_5']['nowcast']}}
        <li>PM2.5: {{ $individualdata->pm2_5 }}</li>
        <li>PM10: {{ $individualdata->pm10 }}</li>
        <li>NO₂: {{ $individualdata->no2 }}</li>
        <li>CO: {{ $individualdata->co }}</li>
        <li>Decibels: {{ $individualdata->decibels }}</li>
        <l1>Peak Decibels: {{$peakDecibels}}</l1>
        <li>Recorded at: {{ $individualdata->created_at }}</li>
    </ul>
@else
    <p>No recent hardware data available.</p>
@endif
            </ul>
            
        </div>
    @else
        <p>No AQI data available.</p>
    @endif
</body>
</html>
