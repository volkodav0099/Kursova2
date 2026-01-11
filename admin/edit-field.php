<?php
// Підключення до бази даних
include('../db/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $land_type = $_POST['land_type'];
    $last_culture = $_POST['last_culture'];
    $allowed_cultures = isset($_POST['allowed_cultures']) ? implode(", ", $_POST['allowed_cultures']) : '';
    $field_condition = $_POST['field_condition'];
    $crop_rotation_method = $_POST['crop_rotation_method'];

    // Оновлення даних у базі (latitude, longitude, boundary_coordinates не змінюються)
    $sql = "UPDATE fields SET name = ?, land_type = ?, last_culture = ?, allowed_cultures = ?, field_condition = ?, crop_rotation_method = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $land_type, $last_culture, $allowed_cultures, $field_condition, $crop_rotation_method, $id);

    if ($stmt->execute()) {
        echo "Дані успішно оновлено!";
        header("Location: index.php");
        exit();
    } else {
        echo "Помилка оновлення!";
    }

    $stmt->close();
} else {
    // Отримуємо дані для поля
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $result = $conn->query("SELECT * FROM fields WHERE id = $id");
    $field = $result->fetch_assoc();

    if (!$field) {
        die("Поле не знайдено!");
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати поле</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Редагувати поле</h2>
    <form action="edit-field.php" method="POST">
        <input type="hidden" name="id" value="<?= $field['id'] ?>">

        <div class="form-group">
            <label for="name">Назва поля</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $field['name'] ?>" required>
        </div>

        <div class="form-group">
            <label for="land_type">Тип землі</label>
            <select class="form-control" id="land_type" name="land_type" required>
                <option value="чорнозем" <?= $field['land_type'] == 'чорнозем' ? 'selected' : '' ?>>Чорнозем</option>
                <option value="підзолистий" <?= $field['land_type'] == 'підзолистий' ? 'selected' : '' ?>>Підзолистий</option>
                <option value="глейовий" <?= $field['land_type'] == 'глейовий' ? 'selected' : '' ?>>Глейовий</option>
                <option value="сірозем" <?= $field['land_type'] == 'сірозем' ? 'selected' : '' ?>>Сірозем</option>
                <option value="луговий" <?= $field['land_type'] == 'луговий' ? 'selected' : '' ?>>Луговий</option>
                <option value="тундровий" <?= $field['land_type'] == 'тундровий' ? 'selected' : '' ?>>Тундровий</option>
            </select>
        </div>

        <div class="form-group">
            <label for="last_culture">Остання культура</label>
            <select class="form-control" id="last_culture" name="last_culture" required>
                <option value="пшениця" <?= $field['last_culture'] == 'пшениця' ? 'selected' : '' ?>>Пшениця</option>
                <option value="кукурудза" <?= $field['last_culture'] == 'кукурудза' ? 'selected' : '' ?>>Кукурудза</option>
                <option value="ячмінь" <?= $field['last_culture'] == 'ячмінь' ? 'selected' : '' ?>>Ячмінь</option>
                <option value="соя" <?= $field['last_culture'] == 'соя' ? 'selected' : '' ?>>Соя</option>
                <option value="рис" <?= $field['last_culture'] == 'рис' ? 'selected' : '' ?>>Рис</option>
                <option value="картопля" <?= $field['last_culture'] == 'картопля' ? 'selected' : '' ?>>Картопля</option>
                <option value="цукровий буряк" <?= $field['last_culture'] == 'цукровий буряк' ? 'selected' : '' ?>>Цукровий буряк</option>
            </select>
        </div>

        <div class="form-group">
            <label for="allowed_cultures">Дозволені культури</label>
            <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="пшениця" <?= in_array('пшениця', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Пшениця</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="кукурудза" <?= in_array('кукурудза', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Кукурудза</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="ячмінь" <?= in_array('ячмінь', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Ячмінь</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="соя" <?= in_array('соя', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Соя</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="рис" <?= in_array('рис', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Рис</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="картопля" <?= in_array('картопля', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Картопля</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="цукровий буряк" <?= in_array('цукровий буряк', explode(', ', $field['allowed_cultures'])) ? 'checked' : '' ?>>
                    <label class="form-check-label">Цукровий буряк</label>
                </div>
            </div>
        </div>


        <div class="form-group">
            <label for="field_condition">Стан поля</label>
            <select class="form-control" id="field_condition" name="field_condition" required>
                <option value="оброблений, з культивацією та удобренням" <?= $field['field_condition'] == 'оброблений, з культивацією та удобренням' ? 'selected' : '' ?>>Оброблений, з культивацією та удобренням</option>
                <option value="скультивований, але без удобрення" <?= $field['field_condition'] == 'скультивований, але без удобрення' ? 'selected' : '' ?>>Скультивований, але без удобрення</option>
                <option value="після збирання, не оброблений" <?= $field['field_condition'] == 'після збирання, не оброблений' ? 'selected' : '' ?>>Після збирання, не оброблений</option>
                <option value="оброблений, але не удобрений" <?= $field['field_condition'] == 'оброблений, але не удобрений' ? 'selected' : '' ?>>Оброблений, але не удобрений</option>
                <option value="підготовлений до сівби, з обробкою грунту" <?= $field['field_condition'] == 'підготовлений до сівби, з обробкою грунту' ? 'selected' : '' ?>>Підготовлений до сівби, з обробкою грунту</option>
            </select>
        </div>

        <div class="form-group">
            <label for="crop_rotation_method">Метод сівозміни</label>
            <select class="form-control" id="crop_rotation_method" name="crop_rotation_method" required>
                <option value="монокультура" <?= $field['crop_rotation_method'] == 'монокультура' ? 'selected' : '' ?>>Монокультура</option>
                <option value="сівозміна" <?= $field['crop_rotation_method'] == 'сівозміна' ? 'selected' : '' ?>>Сівозміна</option>
                <option value="змішана сівозміна" <?= $field['crop_rotation_method'] == 'змішана сівозміна' ? 'selected' : '' ?>>Змішана сівозміна</option>
                <option value="чергування культур" <?= $field['crop_rotation_method'] == 'чергування культур' ? 'selected' : '' ?>>Чергування культур</option>
                <option value="інтенсивна сівозміна" <?= $field['crop_rotation_method'] == 'інтенсивна сівозміна' ? 'selected' : '' ?>>Інтенсивна сівозміна</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Оновити</button>
        <a href="index.php" class="btn btn-secondary">Скасувати</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
