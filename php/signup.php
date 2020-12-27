<?php

$mysqli = new mysqli("localhost", "root", "", "busrs");
 
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

$n = $_POST['name'];
$e = $_POST['email'];
$g = $_POST['gender'];
$p = (int)$_POST['pn'];
$a = (int)$_POST['age'];
$pass = $_POST['pass'];


$hash=md5($pass);

$sql = "INSERT INTO passenger VALUES ('$e','$hash','$n',$p,'$g',$a,'')";

$bool=$mysqli->query($sql);

if($bool){
    echo "Records inserted successfully.";
    die();
       // die("ERROR: Could not able to execute $sql. " . $mysqli->error);
} 

echo "Email OR Phone Number already exist  $mysqli->error";

$mysqli->close();
?>