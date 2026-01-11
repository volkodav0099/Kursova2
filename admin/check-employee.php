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

$name = mysqli_real_escape_string($conn, $_POST['name']);
$surname = mysqli_real_escape_string($conn, $_POST['surname']);
$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
$date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
$pfp_pic_link = mysqli_real_escape_string($conn, $_POST['pfp_pic_link']);

$query = "INSERT INTO `employees` (`id`, `name`, `surname`, `middle_name`, `date_of_birth`, `pfp_pic`) VALUES (NULL, '$name', '$surname', '$middle_name', '$date_of_birth', '$pfp_pic_link')";
if (mysqli_query($conn, $query)) {
    header('Location: index.php');
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
