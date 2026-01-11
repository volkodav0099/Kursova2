<?php
require('./components/Header/index.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Історія</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<section class="story_container">
    <div class="story">
        <div class="storytxt_blck">
            <h1 class="txt1">ТОВ «Сидорівський Бровар» — це українське підприємство, розташоване в селі Сидорів, що на Тернопільщині. Воно спеціалізується на виробництві крафтового пива та інших напоїв, використовуючи традиційні методи пивоваріння.</h1>
        </div>
    </div>
    <div class="story_c">
        <div class="story_txt">
            <div class="stry_title">
                Історія та Особливості
            </div>
            <div class="storyctxt_blck">
                ТОВ «Сидорівський Бровар» відомий своєю прив'язаністю до місцевих традицій та екологічно чистими продуктами. Підприємство прагне підтримувати високі стандарти якості, використовуючи лише натуральні інгредієнти та уникаючи штучних добавок. Виробництво орієнтоване на локальний ринок, але завдяки високій якості продукції броварня здобула популярність і за межами Тернопільщини.
            </div>
        </div>
        <div class="carousel-container">
            <div class="carousel">
                <div><img src="images/1.jpg" alt="1"></div>
                <div><img src="images/2.jpg" alt="2"></div>
                <div><img src="images/3.jpeg" alt="3"></div>
            </div>
        </div>
    </div>
    <div class="story_cr">
        <div class="story_txt">
            <div class="stry_title">
                Асортимент
            </div>
            <div class="storyctxt_blck">
                Пивоварня пропонує різноманітні види пива, кожне з яких має свої особливості смаку та аромату. У виробництві використовуються місцеві зернові культури та джерельна вода, що надає продуктам унікальний смаковий профіль. Окрім пива, підприємство може також виробляти інші напої, такі як сидр або безалкогольні напої, відповідно до сезонних потреб і запитів клієнтів.
            </div>
        </div>
        <div class="carousel-container">
            <div class="carousel">
                <div><img src="images/4.jpg" alt="4"></div>
                <div><img src="images/5.jpg" alt="5"></div>
                <div><img src="images/6.jpg" alt="6"></div>
            </div>
        </div>
    </div>
    <div class="story_c">
        <div class="story_txt">
            <div class="stry_title">
                Роль у Громаді
            </div>
            <div class="storyctxt_blck">
                ТОВ «Сидорівський Бровар» відіграє важливу роль у місцевій громаді, підтримуючи економіку регіону та сприяючи розвитку туризму. Вони активно співпрацюють з місцевими фермерами, підтримуючи сталий розвиток аграрного сектору. Броварня також є учасником різних фестивалів і культурних заходів, які сприяють популяризації регіону.
            </div>
        </div>
        <div class="carousel-container">
            <div class="carousel">
                <div><img src="images/7.jpg" alt="7"></div>
                <div><img src="images/8.jpg" alt="8"></div>
                <div><img src="images/9.jpg" alt="9"></div>
            </div>
        </div>
    </div>
</section>
<div class="boots_back">
    <a href="index.php">Повернутись на головну</a>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    $(document).ready(function() {
        $('.carousel').slick({
            centerMode: true,
            centerPadding: '0',
            dots: true,
            arrows: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 3000 // Час показу кожної фотографії (у мілісекундах)
        });
    });
</script>
</html>