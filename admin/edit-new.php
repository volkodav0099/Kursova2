<?php
session_start();
$login = 'admin';
$pass = 'admin';
if ($_SESSION["login"] !== $login && $_SESSION["password"] !== $pass) {
    header('location: ../login/index.php');
}
$servername = "localhost";
$username = "root";
$password = "";
$db = 'brovar';
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}
?>
<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редагування новини</title>
    <link rel="icon" href="../img/ico2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body class="admin">
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Редагування новини</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            $post_id = $_GET['post_id'];
            $sql = "SELECT * FROM news WHERE id =" .$post_id;;
            $result = mysqli_query($conn, $sql);
            $post = mysqli_fetch_assoc($result);
            ?>
            <form action="./update-new.php" method="post"
                  enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="id"
                       value="<?=$post['id']?>">
                <div class="form-group">
                    <label for="exampleFormControlInput1">Вкажіть назву новини</label>
                    <input name="title" required type="text" class="form-control" id="exampleFormControlInput1" value="<?=$post['title']?>">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Вкажіть зображення для новини</label>
                    <input name="image" type="text" class="form-control" id="exampleFormControlFile1" value="<?=$post['image']?>">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Вкажіть текст новини</label>
                    <textarea name="content" required class="form-control"
                              id="exampleFormControlTextarea1"
                              rows="6"><?=$post['content']?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Обновити новину</button>
                <a href="index.php" class="btn btn-secondary">Скасувати</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>