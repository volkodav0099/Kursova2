<?php
session_start();
$login = 'admin';
$pass = 'admin';
if ($_SESSION["login"] !== $login && $_SESSION["password"] !== $pass){
    header('location: ../login/index.php');
}
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Додати працівника</title>
    <link rel="icon" href="../img/ico2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body class="admin">
<div class="container">
    <div class="row">
        <div class="col">
            <h2>Додати нового працівника</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="./check-employee.php" method="post">
                <div class="form-group">
                    <label for="name">Ім'я:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="surname">Прізвище:</label>
                    <input type="text" class="form-control" id="surname" name="surname" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">По батькові:</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Дата народження:</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="pfp_pic_link">Посилання на зображення:</label>
                    <input type="text" class="form-control" id="pfp_pic_link" name="pfp_pic_link" required>
                </div>
                <button type="submit" class="btn btn-primary">Додати</button>
                <a href="index.php" class="btn btn-secondary">Скасувати</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
