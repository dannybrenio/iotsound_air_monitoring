<?php 


function call($para1, $para2, $para3){
$parameter_one = '';
        $parameter_two = '';
        $parameter_three = '';

        if($para1 != 0){
            
            $parameter_one = 'check1';
        }

          if($para2 != 0){
            
            $parameter_two = 'check2';
        }
          if($para3 != 0){
            
            $parameter_three = 'check3';
        }


        $complete_alert_string = $parameter_one ." ". $parameter_two . " ". $parameter_three;

        return $complete_alert_string;
    }
//make a data creation when the hardware is available1
?>


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
<?php 
$display = call(0,0,2);
echo $display;         
?>

</body>
</html>