<?php

$bsid=(int)$_GET['bsid'];
$dtime=$_GET['dtime'];
$atime=$_GET['atime'];
$fare=$_GET['fare'];
$date=$_GET['date'];
$email=$_GET['email'];
$seatNo=$_GET['seatNo'];
$seatarr=explode(',',$seatNo);
$count=count($seatarr);
$o = $_GET['o'];
$d = $_GET['d'];

$mysql=new mysqli("localhost","root","","busrs");

if($mysql === false){
    die("ERROR: Could not connect. " . $mysql->connect_error);
}
$i=0;

for($i=0;$i<$count;$i++){
    $sql="INSERT into ticket values('','$email',$bsid,'$seatarr[$i]','$fare','$o','$d','$dtime','$atime','$date')";
    if($mysql->query($sql) === true){
    } else{
        echo "ERROR: Could not able to execute $sql. " . $mysql->error;
    }
}

$list="SELECT tid,email,b.regNo,seatNo,fare,origin,destination,
            time_format(departureTime,'%h:%i %p'),time_format(arrivalTime,'%h:%i %p'),date
       FROM ticket t,busschedule bs,bus b
       WHERE t.bsid=bs.bsid AND email='$email' AND origin='$o' AND  destination='$d' AND
            departureTime='$dtime' AND arrivalTime='$atime' AND date='$date' AND seatNo in ($seatNo)
       GROUP BY tid";

if($result = $mysql->query($list)){
    if($result->num_rows > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>Ticket ID</th>";
                echo "<th>Email</th>";
                echo "<th>Bus RegNo</th>";
                echo "<th>Seat No</th>";
                echo "<th>Fare (in .Rs)</th>";
                echo "<th>Origin</th>";
                echo "<th>Destination</th>";
                echo "<th>Departure Time</th>";
                echo "<th>Arrival Time</th>";
                echo "<th>Date</th>";
            echo "</tr>";
            echo "<tbody>";
        while($row = $result->fetch_array()){
            echo "<tr>";
                echo "<td>" . $row['tid'] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["regNo"] . "</td>";
                echo "<td>" . $row['seatNo'] . "</td>";
                echo "<td>" . $row['fare'] . "</td>";
                echo "<td>" . $row['origin'] . "</td>";
                echo "<td>" . $row['destination'] . "</td>";
                echo "<td>" . $row["time_format(departureTime,'%h:%i %p')"] . "</td>";
                echo "<td>" . $row["time_format(arrivalTime,'%h:%i %p')"] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
            echo "</tr>";
        }
        echo '</tbody>';
        echo "</table><br>";
        echo "Please Remember your Ticket ID";
        $result->free();
    } else{
        echo "No records matching your query were found.";
        die();
    }
} else{
    echo "ERROR: Could not able to execute $list. " . $mysql->error;
    die();
}

$mysql->close();
?>