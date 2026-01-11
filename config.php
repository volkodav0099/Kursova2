<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = 'brovar';
$conn = mysqli_connect ($servername, $username, $password, $db);
mysqli_set_charset($conn,"utf8");
if (!$conn) {
    die("Connection failed:" .mysqli_connect_error());
}