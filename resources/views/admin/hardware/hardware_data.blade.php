<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hardware Data</title>
    <h2>Hardware Datas</h2>
</head>
<body>
    <table>
        <tr>
            <th>Hardware Id</th>
            <!-- <th>Hardware Info</th> -->
            <th>PM 2.5</th>
            <th>PM 10</th>
            <th>Co</th>
            <th>No2</th>
            <th>Decibels</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    @foreach($hardware_data as $hardware_datum) 
    <tr>                                  
    <td><p> {{$hardware_datum->hardware_id}} </p></td>
    <!-- //hardware info here -->
    <td><p>{{$hardware_datum->pm2_5 }}</p></td>
    <td><p>{{$hardware_datum->pm10 }}</p></td>
    <td><p>{{$hardware_datum->co }}</p></td>
    <td><p>{{$hardware_datum->no2 }}</p></td>
    <td><p>{{$hardware_datum->decibels }}</p></td>
    <td><p>{{$hardware_datum->created_at}}</p></td> 
    <td><p>{{$hardware_datum->updated_at}}</p></td>
    </tr>
@endforeach
    </table>


</body>
</html>