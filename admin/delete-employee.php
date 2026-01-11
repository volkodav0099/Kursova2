<?php
session_start();
$login = 'admin';
$pass = 'admin';
if ($_SESSION["login"] !== $login && $_SESSION["password"] !== $pass){
    header('location: ../login/index.php');
}
$servername = "localhost";
$username = "root";
$password = "";
$db = 'brovar';
$conn = mysqli_connect($servername, $username, $password, $db);
mysqli_set_charset($conn,"utf8");
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}

$employee_id = $_GET['employee_id'];

// Отримати інформацію про працівника, щоб показати перед підтвердженням видалення
$sql = "SELECT * FROM employees WHERE id = $employee_id";
$result = mysqli_query($conn, $sql);
$employee = mysqli_fetch_assoc($result);

if (!$employee) {
    // Якщо працівник не знайдений, перенаправити на сторінку адмін-панелі
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Видалення працівника
    mysqli_query($conn, "DELETE FROM employees WHERE id = $employee_id");
    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Підтвердження видалення</title>
    <link rel="icon" href="../img/ico2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body class="admin">
<div class="container">
    <h2 class="delete_title">Ви впевнені, що хочете видалити наступного працівника?</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?=$employee['name']?> <?=$employee['surname']?></h5>
            <p class="card-text">Дата народження: <?=$employee['date_of_birth']?></p>
            <form method="POST" action="">
                <input type="hidden" name="employee_id" value="<?=$employee_id?>">
                <button type="submit" class="btn btn-danger">Видалити працівника</button>
                <a href="index.php" class="btn btn-secondary">Скасувати</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
