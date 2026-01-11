<?php
// Отримуємо id з POST запиту
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

include '../db/db_connect.php';

// Отримуємо дані по id
$sql = "SELECT * FROM fields WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$field = $result->fetch_assoc();

// Отримуємо дозволені культури
$allowed_cultures = explode(',', $field['allowed_cultures']); // якщо вони зберігаються як коми

// Формуємо відповідь
$response = [
    'name' => $field['name'],
    'land_type' => $field['land_type'],
    'crop_rotation_method' => $field['crop_rotation_method'],
    'last_culture' => $field['last_culture'],
    'allowed_cultures' => $allowed_cultures,
    'field_condition' => $field['field_condition']
];

// Повертаємо дані у форматі JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);

// Закриваємо з'єднання
$conn->close();
?>
