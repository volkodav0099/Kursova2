<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brovar";

// Підключення до БД
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Помилка підключення до бази: " . $conn->connect_error]);
    exit;
}

// Отримання JSON-даних
$data = json_decode(file_get_contents("php://input"), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["success" => false, "message" => "Некоректний JSON у вхідних даних"]);
    exit;
}

// Перевірка обов’язкових полів
$required_fields = ["full_name", "customer_type", "total_price"];
foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        echo json_encode(["success" => false, "message" => "Пропущено обов'язкове поле: $field"]);
        exit;
    }
}

// Підготовка SQL-запиту
$stmt = $conn->prepare("INSERT INTO orders 
    (full_name, customer_type, company_name, company_code, customer_phone, customer_email, customer_address, customer_comment, status_id, created_at, total_price, total_hectares) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, NOW(), ?, ?)");

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Помилка підготовки запиту: " . $conn->error]);
    exit;
}

// Прив’язка параметрів
$stmt->bind_param(
    "sssssssssd", // 8 рядків + 2 числа
    $data["full_name"],
    $data["customer_type"],
    $data["company_name"],
    $data["company_code"],
    $data["customer_phone"],
    $data["customer_email"],
    $data["customer_address"],
    $data["customer_comment"],
    $data["total_price"],
    $data["total_hectares"]
);

// Виконання запиту
try {
    if (!$stmt->execute()) {
        throw new Exception("Помилка при створенні замовлення: " . $stmt->error);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
}

$order_id = $stmt->insert_id;
$stmt->close();

// Додавання order_fields
if (!empty($data["fields"]) && is_array($data["fields"])) {
    $stmt = $conn->prepare("INSERT INTO order_fields (order_id, field_id) VALUES (?, ?)");
    if ($stmt) {
        foreach ($data["fields"] as $field_id) {
            if (!is_numeric($field_id)) continue;
            $stmt->bind_param("ii", $order_id, $field_id);
            if (!$stmt->execute()) {
                echo json_encode(["success" => false, "message" => "Помилка при додаванні поля: " . $stmt->error]);
                exit;
            }
        }
        $stmt->close();
    }
}

$conn->close();
echo json_encode(["success" => true, "message" => "Замовлення оформлено", "order_id" => $order_id]);
?>
