<?php

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "restaurant_db"; 

$con = mysqli_connect($host, $user, $pass, "restaurant_db");

if (!$con) {
    echo "Error! Connection failed: " . mysqli_connect_error();
    exit;
}
?>
