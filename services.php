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
    <title>Послуги</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<section class="services_container">
    <div class="service-cards">
        <div class="tyr">
            <hr class="services_hr">
            <h2 class="services_title">Туристичні Послуги</h2>
            <hr class="services_hr">
            <div class="service-card">
                <img src="img/tyr.jpg" alt="Тур по броварні">
                <div class="service-info">
                    <h3>Тур по броварні</h3>
                    <p>Опис туру по Сидорівському Броварі з дегустацією напоїв та історією виробництва.</p>
                    <div class="price">
                        <p><strong>Ціна:</strong> 300 грн</p>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <img src="img/master_class.jpg" alt="Майстер-клас з пивоваріння">
                <div class="service-info">
                    <h3>Майстер-клас з пивоваріння</h3>
                    <p>Практичний курс для тих, хто хоче дізнатися, як варити пиво за старовинними рецептами.</p>
                    <div class="price">
                        <p><strong>Ціна:</strong> 500 грн</p>
                    </div>
                </div>
            </div>

            <div class="service-card">
                <img src="img/souvenir.jpg" alt="Сувеніри та подарункові набори">
                <div class="service-info">
                    <h3>Сувеніри та подарункові набори</h3>
                    <p>Придбайте сувенірну продукцію та подарункові набори з продукцією Сидорівського Бровара.</p>
                    <div class="price">
                        <p><strong>Ціна:</strong> від 200 грн</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="agro">
            <hr class="services_hr">
            <h2 class="services_title">Послуги Аграрної Компанії</h2>
            <hr class="services_hr">
                <div class="service-card">
                    <img src="img/breeding.jpg" alt="Розведення свиней">
                    <div class="service-info">
                        <h3>Розведення свиней</h3>
                        <p>Ми пропонуємо якісні послуги з розведення свиней, забезпечуючи здоров'я та гарні умови для тварин.</p>
                        <div class="price">
                            <p><strong>Ціна:</strong> договірна</p>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <img src="img/plant_seeds.jpg" alt="Засівання полів">
                    <div class="service-info">
                        <h3>Засівання полів</h3>
                        <p>Повний спектр послуг з обробки та засівання полів з використанням сучасної техніки та технологій.</p>
                        <div class="price">
                            <p><strong>Ціна:</strong> договірна</p>
                        </div>
                    </div>
                </div>

                <div class="service-card">
                    <img src="img/save.jpg" alt="Зберігання зерна">
                    <div class="service-info">
                        <h3>Зберігання зерна</h3>
                        <p>Надійні послуги зі зберігання зерна в наших сучасних складах з контролем температури та вологості.</p>
                        <div class="price">
                            <p><strong>Ціна:</strong> договірна</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>




<div class="boots_back">
    <a href="index.php">Повернутись на головну</a>
</div>
</body>
</html>