<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = 'brovar';
$conn = mysqli_connect($servername, $username, $password, $db);
mysqli_set_charset($conn,"utf8");
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}

$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$middle_name = $_POST['middle_name'];
$date_of_birth = $_POST['date_of_birth'];
$pfp_pic_link = $_POST['pfp_pic_link'];

$query = "UPDATE `employees` SET `name` = ?, `surname` = ?, `middle_name` = ?, `date_of_birth` = ?, `pfp_pic` = ? WHERE `employees`.`id` = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssssi", $name, $surname, $middle_name, $date_of_birth, $pfp_pic_link, $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header('Location: index.php');
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
