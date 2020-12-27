<?php

$email=$_GET['email'];
$tid=$_GET['tid'];

$mysql=new mysqli("localhost", "root", "", "busrs");

if($mysql === false){
    die("ERROR: Could not connect. " . $mysql->connect_error);
}

$sql=
"SELECT tid,email,b.regNo,seatNo,fare,origin,destination,
        time_format(departureTime,'%h:%i %p'),time_format(arrivalTime,'%h:%i %p'),date,c.name,c.phoneNo
FROM ticket t,busschedule bs,bus b,conductor c
WHERE t.bsid=bs.bsid AND bs.cid=c.cid AND email='$email' AND tid=$tid
GROUP BY tid";

if($result = $mysql->query($sql)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
        echo "<table>";
                echo "<tr><th>Ticket ID</th><td>" . $row['tid'] . "</td></tr>";
                echo "<tr><th>Email</th><td>" . $row["email"] . "</td></tr>";
                echo "<tr><th>Bus RegNo</th><td>" . $row["regNo"] . "</td></tr>";
                echo "<tr><th>Seat No</th><td>" . $row['seatNo'] . "</td></tr>";
                echo "<tr><th>Fare (in .Rs)</th><td>" . $row['fare'] . "</td></tr>";
                echo "<tr><th>Origin</th><td>" . $row['origin'] . "</td></tr>";
                echo "<tr><th>Destination</th><td>" . $row['destination'] . "</td></tr>";
                echo "<tr><th>Departure Time</th><td>" . $row["time_format(departureTime,'%h:%i %p')"] . "</td></tr>";
                echo "<tr><th>Arrival Time</th><td>" . $row["time_format(arrivalTime,'%h:%i %p')"] . "</td></tr>";
                echo "<tr><th>Date</th><td>" . $row['date'] . "</td></tr>";
                echo "<tr><th>Conductor Name</th><td>" . $row['name'] . "</td></tr>";
                echo "<tr><th>Conductor PhoneNo</th><td>" . $row['phoneNo'] . "</td></tr>";
        echo "</table>";
        }
        $result->free();
    } else{
        echo "Ticket Id $tid not booked by your Email";
        die();
    }
} else{
    echo "Server Error";
    die();
}

$mysql->close();



?>