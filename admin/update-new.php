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
$title = $_POST['title'];
$image = $_POST['image'];
$content = $_POST['content'];

$query = "UPDATE `news` SET `title` = ?, `image` = ?, `content` = ? WHERE `news`.`id` = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssi", $title, $image, $content, $id);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header('Location: index.php');
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);


mysqli_close($conn);
?>
