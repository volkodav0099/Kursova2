<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brovar";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка на помилки підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Перевірка чи є POST-запит
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримуємо значення з форми та очищуємо їх
    $name = $conn->real_escape_string($_POST['name']);
    $latitude = $conn->real_escape_string($_POST['latitude']);
    $longitude = $conn->real_escape_string($_POST['longitude']);
    $boundary_coordinates = $conn->real_escape_string($_POST['boundary_coordinates']);
    $land_type = $conn->real_escape_string($_POST['land_type']);
    $last_culture = $conn->real_escape_string($_POST['last_culture']);
    
    // Для дозволених культур - отримуємо масив і перетворюємо його в рядок
    $allowed_cultures = isset($_POST['allowed_cultures']) ? implode(", ", $_POST['allowed_cultures']) : '';
    
    $field_condition = $conn->real_escape_string($_POST['field_condition']);
    $crop_rotation_method = $conn->real_escape_string($_POST['crop_rotation_method']);

    // Перевірка чи всі точки меж були введені
    if (empty($boundary_coordinates)) {
        die("Помилка: Не всі точки меж введені!");
    }

    // Створення SQL запиту для вставки даних
    $sql = "INSERT INTO fields (name, latitude, longitude, boundary_coordinates, land_type, last_culture, allowed_cultures, field_condition, crop_rotation_method) 
            VALUES ('$name', '$latitude', '$longitude', '$boundary_coordinates', '$land_type', '$last_culture', '$allowed_cultures', '$field_condition', '$crop_rotation_method')";

    // Виконання запиту та перевірка на помилки
    if ($conn->query($sql) === TRUE) {
        echo "Ділянка успішно додана!";
        header("Location: index.php");
        exit();
    } else {
        echo "Помилка: " . $conn->error;
    }
}

// Закриваємо підключення до бази даних
$conn->close();
?>
