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
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0>
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Додавання нової новини</title>
    <link rel="icon" href="../img/ico2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body class="admin">
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Додання нової новини</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="./check-new.php" method="post"
                  enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Вкажіть назву
                        новини</label>
                    <input name="title" required type="text" class="form-control"
                           id="exampleFormControlInput1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Вкажіть посилання на
                        зображення новини</label>
                    <input name="image" type="text" class="form-control"
                           id="exampleFormControlFile1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Вкажіть текст
                        новини</label>
                    <textarea name="content" required class="form-control"
                              id="exampleFormControlTextarea1" rows="6"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Створити новину</button>
                <a href="index.php" class="btn btn-secondary">Скасувати</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>