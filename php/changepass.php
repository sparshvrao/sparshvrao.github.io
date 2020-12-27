<?php

$mysqli = new mysqli("localhost", "root", "", "busrs");
 
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

$opass = $_POST['opass'];
$e = $_POST['email'];
$npass = $_POST['npass'];
$opass=md5($opass);
$npass=md5($npass);


$sql = 
"SELECT * FROM passenger 
WHERE password='$opass' AND email='$e'";

$bool=$mysqli->query($sql);

if($bool->num_rows==0){
    echo "Old password not matching with your Email";
    die();
       // die("ERROR: Could not able to execute $sql. " . $mysqli->error);
} 

$sql = 
"UPDATE passenger
SET password='$npass' 
WHERE password='$opass' AND email='$e'";

$mysqli->query($sql);
echo "Password updated successfully.";

$mysqli->close();
?>