<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "brovar";

    // Підключення до бази даних
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Перевірка на помилки підключення
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }