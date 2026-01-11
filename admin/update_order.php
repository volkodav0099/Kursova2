<?php
include '../db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: text/plain; charset=utf-8"); // ✅ Виправляє проблеми з кодуванням

    $id = intval($_POST['id']);
    $field = $_POST['field'];
    $value = trim($_POST['value']);

    // ✅ Біла список полів + типи
    $field_whitelist = [
        'full_name' => 's',
        'company_name' => 's',
        'company_code' => 's',
        'customer_phone' => 's',
        'customer_email' => 's',
        'status_id' => 'i'
    ];

    if (!array_key_exists($field, $field_whitelist)) {
        die("Неправильне поле");
    }
    
    // Перевірка, чи можна редагувати company_name і company_code
    if (in_array($field, ['company_name', 'company_code'])) {
        $stmt = $conn->prepare("SELECT customer_type FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($customer_type);
        $stmt->fetch();
        $stmt->close();
    
        if ($customer_type === 'Фізична особа') {
            echo "Редагування полів компанії для фізичних осіб заборонено.";
            exit;
        }
    }
    

    // ✅ Оновлення
    $sql = "UPDATE orders SET " . $field . " = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($field_whitelist[$field] === 'i') {
        $stmt->bind_param("ii", $value, $id);
    } else {
        $stmt->bind_param("si", $value, $id);
    }

    if ($stmt->execute()) {
        echo "Оновлено";
    } else {
        echo "Помилка оновлення: " . $stmt->error;
    }

    $stmt->close();
}
?>
