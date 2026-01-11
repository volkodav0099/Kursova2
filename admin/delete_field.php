<?php
    include '../db/db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['field_id'])) {
        $field_id = intval($_POST['field_id']);

        $conn->begin_transaction(); // Починаємо транзакцію

        try {
            // Видаляємо поле
            $delete_sql = "DELETE FROM fields WHERE id = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $field_id);
            $stmt->execute();
            $stmt->close();

            // Перенумеровуємо ID в таблиці, щоб не було пропусків
            $update_sql = "SET @new_id := 0";
            $conn->query($update_sql);

            $reset_sql = "UPDATE fields SET id = (@new_id := @new_id + 1) ORDER BY id";
            $conn->query($reset_sql);

            // Фіналізуємо транзакцію
            $conn->commit();
            echo json_encode(["success" => true]);
        } catch (Exception $e) {
            $conn->rollback(); // Відкат у разі помилки
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }

        $conn->close();
    }
?>
