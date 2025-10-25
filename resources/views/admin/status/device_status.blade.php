<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Device Status</title>
</head>
<body>
    <table>
        <tr>
            <th>Status Id</th>
            <th>Hardware Info</th>
            <th>PMS Status</th>
            <th>MQ135 Status</th>
            <th>MQ7 Status</th>
            <th>Sound Status</th>
            <th>Timestamp Status</th>
            <th>Created At</th>
        </tr>
    @foreach($device_statuses as $device_status) 
    <tr>                                  
    <td><p> {{$device_status->status_id}} </p></td>
    <td><p> {{$device_status->hardware_info}} </p></td>
    <td><p> {{$device_status->pms_status}} </p></td>
    <td><p> {{$device_status->mq135_status}} </p></td> 
    <td><p> {{$device_status->mq7_status}} </p></td>
    <td><p> {{$device_status->sound_status}} </p></td>
    <td><p> {{$device_status->timestamp_status}} </p></td>
    <td><p> {{$device_status->created_at}} </p></td>
                    </tr>
@endforeach
    </table>
</body>
</html>