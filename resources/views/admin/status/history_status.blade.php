</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>History Status</title>
</head>
<body>
    <table>
        <tr>
            <th>History Id</th>
            <th>Hardware Info</th>
            <th>Sensor Type</th>
            <th>Sensor Status</th>
            <th>Created At</th>
        </tr>
    @foreach($history_statuses as $history_status) 
    <tr>                                  
    <td><p> {{$history_status->history_id}} </p></td>
    <td><p> {{$history_status->device_status?->hardware_info}} </p></td>
    <td><p> {{$history_status->sensor_type}} </p></td>
     <td><p> {{$history_status->sensor_status}} </p></td>
    <td><p> {{$history_status->created_at}} </p></td>
                    </tr>
@endforeach
    </table>
</body>
</html>