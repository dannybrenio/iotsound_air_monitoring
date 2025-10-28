<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alert Logs</title>
    <h2>Alert Logs</h2>
</head>

<body>
    <table>
            <tr>
                <th>Alert Id</th>
                <th>Alert Body</th>
            </tr>  

    @foreach($alerts as $alert)
   <tr>
        <td><p>{{$alert->alert_id}}</p></td>
        <td><p>{{$alert->alert_body}}</p></td>
   </tr>
@endforeach
    </table>


</body>
</html>