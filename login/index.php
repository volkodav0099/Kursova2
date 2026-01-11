<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../img/ico2.png">
    <link rel="stylesheet" href="../styles/login.css">
    <title>Увійти | Адмін панель</title>
</head>
<body>
<div class="wrapper">
    <div class="container">
        <form action="check-login.php" class="form" method="post">
            <h2>Адмін панель</h2>
            <div class="form_container">
                    <input type="text" name="login">
                    <input type="password" name="password">
                <button class="button">Увійти</button>
                <a href="../index.php" class="button">Назад</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>