<?php
require('components/Header/index.php');
require_once('config.php');
$sql = "SELECT * FROM news";
$result = mysqli_query($conn, $sql);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <title>Новини</title>
</head>
<body>
<section class="category_container">
    <?php foreach ($result as $news):?>
        <div class="news_card">
            <div class="news_card_info">
                <img src="<?=$news['image']?>" class="news_card_image" alt="<?=$news['title']?>">
                <p class="news_card_title"><?=$news['title']?></p>
            </div>
            <div>
                <span><?= mb_substr($news['content'],0,80) . '...';?></span>
            </div>
            <div class="news_card_buttons">
                <a href="news.php?id=<?=$news['id']?>" class="news_card_button">Читати більше</a>
            </div>
        </div>
    <?php endforeach;?>
    <div class="boots_back">
        <a href="index.php">Повернутись на головну</a>
    </div>
</section>
</body>
</html>