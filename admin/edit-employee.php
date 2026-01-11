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
$conn = mysqli_connect ($servername, $username, $password, $db);
mysqli_set_charset($conn,"utf8");
if (!$conn) {
    die("Connection failed:" .mysqli_connect_error());
}

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    $sql = "SELECT * FROM employees WHERE id = $employee_id";
    $result = mysqli_query($conn, $sql);
    $employee = mysqli_fetch_assoc($result);
}
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редагувати працівника</title>
    <link rel="icon" href="../img/ico2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body class="admin">
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Редагувати дані працівника</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="update-employee.php" method="post">
                <input type="hidden" name="id" value="<?=$employee['id']?>">
                <div class="form-group">
                    <label for="name">Ім'я:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$employee['name']?>" required>
                </div>
                <div class="form-group">
                    <label for="surname">Прізвище:</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="<?=$employee['surname']?>" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">По батькові:</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?=$employee['middle_name']?>" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Дата народження:</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?=$employee['date_of_birth']?>" required>
                </div>
                <div class="form-group">
                    <label for="pfp_pic_link">Посилання на зображення:</label>
                    <input type="text" class="form-control" id="pfp_pic_link" name="pfp_pic_link" value="<?=$employee['pfp_pic']?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Зберегти зміни</button>
                <a href="index.php" class="btn btn-secondary">Скасувати</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
