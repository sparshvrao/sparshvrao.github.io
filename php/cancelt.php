<?php

$mysqli = new mysqli("localhost", "root", "", "busrs");
 
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

$tid = $_GET['tid'];
$e = $_GET['email'];

$sql=
"SELECT date from ticket
WHERE tid=$tid";

$result=$mysqli->query($sql);
if($result->num_rows>0){
    $row=$result->fetch_array();
}else{
    echo "<br>Ticket Id $tid not booked by your Email";
    die();
}
if(date("Y-m-d")>=$row['date']){
    echo "<br>Opps!! you cannot cancel today's or already expired ticket";
    die();
}


$sql = 
"DELETE FROM ticket 
WHERE tid=$tid AND email='$e'";

$bool=$mysqli->query($sql);

if($bool){
    echo "<br>Ticket cancelled successfully.";
    die();
       // die("ERROR: Could not able to execute $sql. " . $mysqli->error);
} 

echo "<br>Ticket Id $tid not booked by your Email";

$mysqli->close();
?>