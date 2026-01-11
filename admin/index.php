<?php
session_start();
$login = 'admin';
$pass = 'admin';
if ($_SESSION["login"] !== $login && $_SESSION["password"] !== $pass) {
    header('location: ../login/index.php');
}

include '../db/db_connect.php';
?>

<!doctype html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Адмін-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrJ7H5qYmz2kqfzhSD0WM-qC56OFm4o8w&libraries=geometry&async"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/admin.css">
</head>

<body class="admin">
    <div class="container">
        <div class="row align-items-center mb-3">
            <div class="col-md-10">
                <h2 class="fw-bold text-primary">Адміністративна панель</h2>
            </div>
            <div class="col-md-2 text-end">
                <a href="../index.php" class="btn btn-outline-danger">Вихід</a>
            </div>
        </div>

        <!-- Меню вкладок -->
        <ul class="nav nav-tabs mt-3 border-bottom-0">
            <li class="nav-item">
                <a href="#" class="nav-link active fw-semibold text-dark" data-tab="news-tab">Новини</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link fw-semibold text-dark" data-tab="employees-tab">Працівники</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link fw-semibold text-dark" data-tab="Order-tab">Замовлення</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link fw-semibold text-dark" data-tab="fields-tab">Земля</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link fw-semibold text-dark" data-tab="fields-list-tab">Ділянки</a>
            </li>
        </ul>

        <!-- Контент вкладок -->
        <div class="tab-content active" id="news-tab">
            <h2 class="text-center mb-2">Новини</h2>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Назва новини</th>
                        <th scope="col">Редагування</th>
                        <th scope="col">Видалення</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Отримуємо загальну кількість новин
                    $total_records_sql = "SELECT COUNT(*) AS total FROM news";
                    $total_result = mysqli_query($conn, $total_records_sql);
                    $total_records = mysqli_fetch_assoc($total_result)['total'];

                    // Кількість новин на сторінці
                    $records_per_page = 10;

                    // Поточна сторінка
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $records_per_page;

                    // SQL-запит з пагінацією
                    $sql = "SELECT * FROM news LIMIT $offset, $records_per_page";
                    $result = mysqli_query($conn, $sql);

                    $counter = $offset + 1; // Початковий номер для цієї сторінки
                    foreach ($result as $post): ?>
                        <tr>
                            <th scope="row"><?= $counter++ ?></th>
                            <td><?= htmlspecialchars($post['title']) ?></td>
                            <td><a href="edit-new.php?post_id=<?= $post['id'] ?>" class="btn btn-warning">Редагувати</a>
                            </td>
                            <td><a href="delete.php?post_id=<?= $post['id']; ?>" class="btn btn-danger">Видалити</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Пагінація -->
            <!-- <div class="pagination">
            <?php
            $total_pages = ceil($total_records / $records_per_page);

            // Кнопка попередньої сторінки
            if ($current_page > 1) {
                echo '<a href="?page=' . ($current_page - 1) . '">&laquo; Попередня</a>';
            }

            // Кнопки для сторінок
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page=' . $i . '" ' . ($i == $current_page ? 'class="active"' : '') . '>' . $i . '</a>';
            }

            // Кнопка наступної сторінки
            if ($current_page < $total_pages) {
                echo '<a href="?page=' . ($current_page + 1) . '">Наступна &raquo;</a>';
            }
            ?>
        </div> -->

            <a href="add-new.php" class="btn btn-success">Додати новину</a>
        </div>

        <div class="tab-content" id="employees-tab">
            <h2 class="text-center mb-2">Працівники</h2>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Ім'я</th>
                        <th scope="col">Прізвище</th>
                        <th scope="col">По батькові</th>
                        <th scope="col">Дата народження</th>
                        <th scope="col">Редагування</th>
                        <th scope="col">Видалення</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Отримуємо загальну кількість працівників
                    $total_records_sql = "SELECT COUNT(*) AS total FROM employees";
                    $total_result = mysqli_query($conn, $total_records_sql);
                    $total_records = mysqli_fetch_assoc($total_result)['total'];

                    // Кількість працівників на сторінці
                    $records_per_page = 10;

                    // Поточна сторінка
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $records_per_page;

                    // SQL-запит з пагінацією
                    $sql = "SELECT * FROM employees LIMIT $offset, $records_per_page";
                    $result = mysqli_query($conn, $sql);

                    $counter = $offset + 1; // Початковий номер для цієї сторінки
                    foreach ($result as $employee): ?>
                        <tr>
                            <th scope="row"><?= $counter++ ?></th>
                            <td><?= htmlspecialchars($employee['name']) ?></td>
                            <td><?= htmlspecialchars($employee['surname']) ?></td>
                            <td><?= htmlspecialchars($employee['middle_name']) ?></td>
                            <td><?= htmlspecialchars($employee['date_of_birth']) ?></td>
                            <td><a href="edit-employee.php?employee_id=<?= $employee['id'] ?>"
                                    class="btn btn-warning">Редагувати</a></td>
                            <td><a href="delete-employee.php?employee_id=<?= $employee['id']; ?>"
                                    class="btn btn-danger">Видалити</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Пагінація -->
            <!-- <div class="pagination">
            <?php
            $total_pages = ceil($total_records / $records_per_page);

            // Кнопка попередньої сторінки
            if ($current_page > 1) {
                echo '<a href="?page=' . ($current_page - 1) . '">&laquo; Попередня</a>';
            }

            // Кнопки для сторінок
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page=' . $i . '" ' . ($i == $current_page ? 'class="active"' : '') . '>' . $i . '</a>';
            }

            // Кнопка наступної сторінки
            if ($current_page < $total_pages) {
                echo '<a href="?page=' . ($current_page + 1) . '">Наступна &raquo;</a>';
            }
            ?>
        </div> -->

            <a href="add-employee.php" class="btn btn-success">Додати працівника</a>
        </div>

        <div class="tab-content" id="Order-tab">
            <h2 class="text-center mb-2">Закази на Оренду</h2>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Ім'я</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Компанія (код)</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Email</th>
                        <th scope="col">Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Отримуємо загальну кількість заказів
                    $total_records_sql = "SELECT COUNT(*) AS total FROM orders";
                    $total_result = mysqli_query($conn, $total_records_sql);
                    $total_records = mysqli_fetch_assoc($total_result)['total'];

                    // Кількість заказів на сторінці
                    $records_per_page = 10;

                    // Поточна сторінка
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $records_per_page;

                    // SQL-запит з пагінацією
                    $sql = "SELECT * FROM orders LIMIT $offset, $records_per_page";
                    $result = mysqli_query($conn, $sql);

                    $status_options = [
                        1 => 'Очікується',
                        2 => 'Обробляється',
                        3 => 'Виконано',
                        4 => 'Закрито'
                    ];

                    $counter = $offset + 1; // Початковий номер для цієї сторінки
                    foreach ($result as $post):
                        $is_physical = ($post['customer_type'] == 'Фізична особа');
                        $company_info = $post['company_name'] ? "{$post['company_name']} ({$post['company_code']})" : "Немає";
                        ?>
                        <tr data-id="<?= $post['id'] ?>">
                            <th scope="row"><?= $counter++ ?></th>
                            <td contenteditable="true" class="editable" data-field="full_name">
                                <?= htmlspecialchars($post['full_name']) ?></td>
                            <td><?= htmlspecialchars($post['customer_type']) ?></td>
                            <td class="company-field <?= $is_physical ? 'non-editable' : 'editable' ?>"
                                data-field="company_info" <?= $is_physical ? '' : 'contenteditable="true"' ?>>
                                <?= htmlspecialchars($company_info) ?>
                            </td>
                            <td contenteditable="true" class="editable" data-field="customer_phone">
                                <?= htmlspecialchars($post['customer_phone']) ?></td>
                            <td contenteditable="true" class="editable" data-field="customer_email">
                                <?= htmlspecialchars($post['customer_email']) ?></td>
                            <td>
                                <select class="status-update" data-id="<?= $post['id'] ?>">
                                    <?php foreach ($status_options as $key => $value): ?>
                                        <option value="<?= $key ?>" <?= ($key == $post['status_id']) ? 'selected' : '' ?>>
                                            <?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="order-details" data-id="<?= $post['id'] ?>" style="display: none;">
                            <td colspan="7">
                                <strong>Адреса:</strong> <?= htmlspecialchars($post['customer_address']) ?><br>
                                <strong>Коментар:</strong> <?= $post['customer_comment'] ?: 'Немає коментаря' ?><br>
                                <strong>Ціна(рік):</strong> <?= number_format($post['total_price'], 2) ?> USD<br>
                                <strong>Гектари:</strong> <?= htmlspecialchars($post['total_hectares']) ?><br>
                                <strong>Дата замовлення:</strong> <?= htmlspecialchars($post['created_at']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Пагінація -->
            <!-- <div class="pagination">
            <?php
            $total_pages = ceil($total_records / $records_per_page);

            // Кнопка попередньої сторінки
            if ($current_page > 1) {
                echo '<a href="?page=' . ($current_page - 1) . '">&laquo; Попередня</a>';
            }

            // Кнопки для сторінок
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page=' . $i . '" ' . ($i == $current_page ? 'class="active"' : '') . '>' . $i . '</a>';
            }

            // Кнопка наступної сторінки
            if ($current_page < $total_pages) {
                echo '<a href="?page=' . ($current_page + 1) . '">Наступна &raquo;</a>';
            }
            ?>
        </div> -->
        </div>

        <div class="tab-content" id="fields-tab">
            <h2 class="text-center mb-2">Додавання земельної ділянки</h2>
            <p class="text-center">Клікніть на карту: перша точка визначає центр ділянки (маркер), наступні точки — межі
                ділянки. Мінімум 4 точки для замикання ділянки, додаткові точки можуть бути додані для уточнення форми.
                Кількість точок має бути парною (4, 6, 8 і т.д.).</p>

            <div id="map"></div>
            <button id="undoBtn" class="btn btn-warning my-3 d-block mx-auto" disabled>Відмінити останній клік</button>

            <form action="add_field.php" method="POST" class="p-4 bg-light rounded shadow-sm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Назва ділянки:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Тип землі:</label>
                        <select name="land_type" class="form-select" required>
                            <option value="чорнозем">Чорнозем</option>
                            <option value="підзолистий">Підзолистий</option>
                            <option value="глейовий">Глейовий</option>
                            <option value="сірозем">Сірозем</option>
                            <option value="луговий">Луговий</option>
                            <option value="тундровий">Тундровий</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Система сівозміни:</label>
                        <select name="crop_rotation_method" class="form-select" required>
                            <option value="монокультура">Монокультура</option>
                            <option value="сівозміна">Сівозміна</option>
                            <option value="змішана сівозміна">Змішана сівозміна</option>
                            <option value="чергування культур">Чергування культур</option>
                            <option value="інтенсивна сівозміна">Інтенсивна сівозміна</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Остання культура:</label>
                        <select name="last_culture" class="form-select" required>
                            <option value="пшениця">Пшениця</option>
                            <option value="кукурудза">Кукурудза</option>
                            <option value="ячмінь">Ячмінь</option>
                            <option value="соя">Соя</option>
                            <option value="рис">Рис</option>
                            <option value="картопля">Картопля</option>
                            <option value="цукровий буряк">Цукровий буряк</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Дозволені культури:</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="пшениця">
                            <label class="form-check-label">Пшениця</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="кукурудза">
                            <label class="form-check-label">Кукурудза</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="ячмінь">
                            <label class="form-check-label">Ячмінь</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="соя">
                            <label class="form-check-label">Соя</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="рис">
                            <label class="form-check-label">Рис</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]" value="картопля">
                            <label class="form-check-label">Картопля</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="allowed_cultures[]"
                                value="цукровий буряк">
                            <label class="form-check-label">Цукровий буряк</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Стан поля:</label>
                    <select name="field_condition" class="form-select" required>
                        <option value="оброблений, з культивацією та удобренням">Оброблений, з культивацією та
                            удобренням</option>
                        <option value="скультивований, але без удобрення">Скультивований, але без удобрення</option>
                        <option value="після збирання, не оброблений">Після збирання, не оброблений</option>
                        <option value="оброблений, але не посіяний">Оброблений, але не посіяний</option>
                        <option value="підготовлений до сівби, з обробкою грунту">Підготовлений до сівби, з обробкою
                            грунту</option>
                    </select>
                </div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="boundary_coordinates" id="boundary_coordinates">

                <button type="submit" class="btn btn-success w-100">Додати ділянку</button>
            </form>
        </div>

        <div class="tab-content" id="fields-list-tab">
            <h2 class="text-center mb-2">Інформація про поля</h2>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Назва</th>
                        <th scope="col">Тип землі</th>
                        <th scope="col">Остання культура</th>
                        <th scope="col">Дозволені культури</th>
                        <th scope="col">Стан поля</th>
                        <th scope="col">Метод сівозміни</th>
                        <th scope="col" class="text-center">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Отримуємо загальну кількість записів
                    $total_records_sql = "SELECT COUNT(*) AS total FROM fields";
                    $total_result = mysqli_query($conn, $total_records_sql);
                    $total_records = mysqli_fetch_assoc($total_result)['total'];

                    // Кількість записів на сторінці
                    $records_per_page = 10;

                    // Поточна сторінка
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $records_per_page;

                    // SQL-запит з пагінацією
                    $sql = "SELECT * FROM fields LIMIT $offset, $records_per_page";
                    $result = mysqli_query($conn, $sql);

                    $counter = $offset + 1; // Початковий номер для цієї сторінки
                    foreach ($result as $post): ?>
                        <tr>
                            <th scope="row"><?= $counter++ ?></th>
                            <td><?= htmlspecialchars($post['name']) ?></td>
                            <td><?= htmlspecialchars($post['land_type']) ?></td>
                            <td><?= htmlspecialchars($post['last_culture']) ?></td>
                            <td><?= htmlspecialchars($post['allowed_cultures']) ?></td>
                            <td><?= htmlspecialchars($post['field_condition']) ?></td>
                            <td><?= htmlspecialchars($post['crop_rotation_method']) ?></td>
                            <td class="text-center">
                                <button class="btn btn-info btn-sm"
                                    onclick="window.location.href='edit-field.php?id=<?= $post['id'] ?>'">
                                    <i class="fas fa-map"></i> Редагувати
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteField(<?= $post['id'] ?>)">
                                    <i class="fas fa-trash"></i> Видалити
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Пагінація -->
            <!-- <div class="pagination">
            <?php
            $total_pages = ceil($total_records / $records_per_page);

            // Кнопка попередньої сторінки
            if ($current_page > 1) {
                echo '<a href="?page=' . ($current_page - 1) . '">&laquo; Попередня</a>';
            }

            // Кнопки для сторінок
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="?page=' . $i . '" ' . ($i == $current_page ? 'class="active"' : '') . '>' . $i . '</a>';
            }

            // Кнопка наступної сторінки
            if ($current_page < $total_pages) {
                echo '<a href="?page=' . ($current_page + 1) . '">Наступна &raquo;</a>';
            }
            ?>
        </div> -->
        </div>
    </div>
    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Знімаємо активність з усіх кнопок і вкладок
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));

                // Додаємо активність до вибраної кнопки і відповідної вкладки
                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });

        function deleteField(fieldId) {
            if (confirm("Ви впевнені, що хочете видалити поле?")) {
                fetch('delete_field.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `field_id=${fieldId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Поле успішно видалено");
                            location.reload();
                        } else {
                            alert("Помилка при видаленні: " + data.error);
                        }
                    })
                    .catch(error => console.error("Помилка:", error));
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Живе редагування
            document.querySelectorAll(".editable").forEach(cell => {
                cell.addEventListener("blur", function () {
                    let id = this.closest("tr").dataset.id;
                    let field = this.dataset.field;
                    let value = this.innerText.trim();

                    // Якщо редагується поле company_info, розділяємо на company_name і company_code, але не передаємо company_info
                    if (field === 'company_info') {
                        const parts = value.split('(');
                        const company_name = parts[0].trim();
                        const company_code = parts[1] ? parts[1].replace(')', '').trim() : '';

                        // Оновлюємо окремо company_name та company_code
                        updateOrderField(id, 'company_name', company_name);
                        updateOrderField(id, 'company_code', company_code);
                    } else {
                        // Для інших полів передаємо звичайне значення
                        updateOrderField(id, field, value);
                    }
                });
            });

            // Зміна статусу
            document.querySelectorAll(".status-update").forEach(select => {
                select.addEventListener("change", function () {
                    let id = this.dataset.id;
                    let status_id = this.value;
                    updateOrderField(id, "status_id", status_id);
                });
            });

            // Розгортання деталей
            document.querySelectorAll("tr[data-id]").forEach(row => {
                row.addEventListener("click", function () {
                    let id = this.dataset.id;
                    let detailsRow = document.querySelector(`.order-details[data-id='${id}']`);
                    detailsRow.style.display = (detailsRow.style.display === "none") ? "table-row" : "none";
                });
            });

            // Функція для оновлення поля
            function updateOrderField(id, field, value) {
                console.log(`Передано: id=${id}, field=${field}, value=${value}`);
                fetch("update_order.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `id=${id}&field=${field}&value=${encodeURIComponent(value)}`
                })
                    .then(response => response.text())
                    .then(data => console.log(data))
                    .catch(error => console.error("Помилка:", error));
            }

            // Блокування редагування компанії для фізичних осіб
            document.querySelectorAll(".company-field.non-editable").forEach(field => {
                field.addEventListener("focus", function () {
                    this.blur(); // Забороняє редагування
                });
            });
        });
    </script>

    <script>
        let map;
        let marker = null;
        let polygon = null;
        let boundaryPoints = [];
        let existingPolygons = [];

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 49.020176, lng: 26.151417 },
                zoom: 17,
                mapTypeId: "satellite"
            });

            loadExistingFields();

            map.addListener("click", function (event) {
                handleMapClick(event.latLng);
            });

            document.getElementById("undoBtn").addEventListener("click", undoLastPoint);

            // Вимикаємо стандартну підказку для зменшення масштабу за допомогою Ctrl
            document.addEventListener("keydown", function (event) {
                if (event.ctrlKey && (event.key === "=" || event.key === "-")) {
                    event.preventDefault(); // Призупиняємо стандартну поведінку
                }
            });
        }

        function handleMapClick(latLng) {
            if (!marker) {
                // Перша точка - маркер (центр ділянки)
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    title: "Центр ділянки"
                });

                // Додаємо можливість видалення першого маркера при кліку на нього
                marker.addListener("click", function () {
                    removeFirstMarker();
                });

                document.getElementById("latitude").value = latLng.lat();
                document.getElementById("longitude").value = latLng.lng();
            } else {
                // Додаємо точки меж ділянки
                boundaryPoints.push(latLng);
                document.getElementById("undoBtn").disabled = false;

                if (polygon) polygon.setMap(null); // Видаляємо старий полігон

                polygon = new google.maps.Polygon({
                    paths: boundaryPoints,
                    strokeColor: "#f0c674",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#f0c674",
                    fillOpacity: 0.35
                });

                polygon.setMap(map);

                // Перевірка, що кількість точок мінімум 4 і кратна 2
                if (boundaryPoints.length >= 4 && boundaryPoints.length % 2 === 0) {
                    document.getElementById("boundary_coordinates").value = JSON.stringify(
                        boundaryPoints.map(point => ({ lat: point.lat(), lng: point.lng() }))
                    );
                }
            }
        }

        function removeFirstMarker() {
            if (marker) {
                marker.setMap(null);
                marker = null;
                document.getElementById("latitude").value = "";
                document.getElementById("longitude").value = "";
                boundaryPoints = [];  // Очищаємо точки меж, оскільки перший маркер видалений
                if (polygon) polygon.setMap(null);  // Видаляємо старий полігон
            }
        }

        function undoLastPoint() {
            if (boundaryPoints.length > 0) {
                boundaryPoints.pop();
            } else if (marker) {
                removeFirstMarker();
            }

            if (polygon) polygon.setMap(null);

            if (boundaryPoints.length > 0) {
                polygon = new google.maps.Polygon({
                    paths: boundaryPoints,
                    strokeColor: "#f0c674",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#f0c674",
                    fillOpacity: 0.35
                });

                polygon.setMap(map);
            }

            document.getElementById("undoBtn").disabled = boundaryPoints.length === 0 && !marker;
        }

        function loadExistingFields() {
            fetch("get_fields.php")
                .then(response => response.json())
                .then(fields => {
                    fields.forEach(field => {
                        const fieldPolygon = new google.maps.Polygon({
                            paths: JSON.parse(field.boundary_coordinates),
                            strokeColor: "#ff0000",
                            strokeOpacity: 0.8,
                            strokeWeight: 2,
                            fillColor: "#ff0000",
                            fillOpacity: 0.35
                        });

                        fieldPolygon.setMap(map);
                        existingPolygons.push(fieldPolygon);
                    });
                })
                .catch(error => console.error("Помилка завантаження полів:", error));
        }

        window.onload = initMap;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>