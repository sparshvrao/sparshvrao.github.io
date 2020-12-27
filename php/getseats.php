<?php

$bsid=$_GET['bsid'];
$dtime=$_GET['dtime'];
$atime=$_GET['atime'];
$fare=$_GET['fare'];
$date=$_GET['date'];

$mysql=new mysqli("localhost","root","","busrs");

if($mysql === false){
    die("ERROR: Could not connect. " . $mysql->connect_error);
}


//getting booked seat numbers from ticket
$sql=
"SELECT seatNo
FROM ticket
WHERE bsid=$bsid  AND departureTime >= '$dtime'  And arrivalTime <= '$atime' AND date='$date';";

$i=0;
$arr= array();

if($result=$mysql->query($sql)){
    if($result->num_rows>0){
        while($row=$result->fetch_array()){
            $arr[$i++]=$row['seatNo'];
        }
    }
    $result->free();
}else{
    echo "ERROR: Could not able to execute $sql. " . $mysql->error;
    die();
}

//getting max seats from given BusSchedule Id
$sqlmaxseats=
"SELECT maxSeats
FROM bus b,busschedule bs
WHERE bs.bsid=$bsid  AND b.regNo=bs.regNo;";

$resultmax = $mysql->query($sqlmaxseats);
$row = $resultmax->fetch_array();
$maxseats=$row['maxSeats'];


for($j=1;$j<=$maxseats;$j++){
    if(in_array($j,$arr)){
        echo '<div>'.$j.'</div>';
    }else{
        echo '<input id="'.$j.'"  type="checkbox" name="n" value="'.$j.'"/>
        <label for="'.$j.'">'.$j.'</label>';
    }
}
$mysql->close();

?>