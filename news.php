<?php
$news_id = $_GET['id'];
if (!is_numeric($news_id)) exit();
require_once('config.php');
$sql = "SELECT * FROM news WHERE id =" .$news_id;
$result = mysqli_query($conn, $sql);
$news = mysqli_fetch_assoc($result)
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="img/ico2.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <title>Новини | <?=$news['title']?></title>
</head>
<body>
<?php
require('./components/Header/index.php')
?>
<section class="news_container">
    <div class="single_news_card_container">
        <div>
            <img class="single_news_card_image" src="<?=$news['image']?>" alt="">
        </div>
        <div class="single_news_card_info">
            <h2 class="single_news_card_title"><?=$news['title']?></h2>
            <h3 class="single_news_card_content"><?=nl2br($news['content'])?></h3>
        </div>
    </div>
</section>
<div class="button_position">
    <a class="back" href="category.php">Повернутись назад</a>
</div>
</body>
</html>