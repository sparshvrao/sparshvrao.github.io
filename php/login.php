<?php

$mysql = new mysqli("localhost", "root", "", "busrs");
 
if($mysql === false){
    die("ERROR: Could not connect. " . $mysql->connect_error);
}


$e = $_POST['email'];
$pass = $_POST['pass'];

$hash=md5($pass);

$sql = 
"SELECT Email FROM passenger 
WHERE Email='$e' AND password='$hash'";

if($result=$mysql->query($sql)){
    if($result->num_rows>0){
        echo './book.html?email='.$e;
        die();
    }else{
        echo "Invalid Email or Password\nPlease Signup before Login";
    }
} else{
    echo "Server Error";
}
 
$mysql->close();
?>