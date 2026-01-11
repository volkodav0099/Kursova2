<?php
include 'db/db_connect.php';

// Отримуємо дані з таблиці fields
$sql_fields = "SELECT * FROM fields";
$result_fields = $conn->query($sql_fields);

$fields = [];
if ($result_fields === false) {
    echo "Error: " . $conn->error;
} else {
    if ($result_fields->num_rows > 0) {
        while ($row = $result_fields->fetch_assoc()) {
            $fields[] = $row;
        }
    }
}

// Отримуємо дані з таблиці order_fields та orders для визначення орендованих полів
$sql_order_fields = "SELECT of.field_id, o.full_name 
                        FROM order_fields of
                        JOIN orders o ON of.order_id = o.id
                        WHERE o.status_id != 4";

$result_order_fields = $conn->query($sql_order_fields);

$rented_fields = [];
if ($result_order_fields === false) {
    echo "Error: " . $conn->error;
} else {
    if ($result_order_fields->num_rows > 0) {
        while ($row = $result_order_fields->fetch_assoc()) {
            $rented_fields[] = [
                'field_id' => $row['field_id'],
                'full_name' => $row['full_name']
            ];
        }
    }
}

// Об'єднуємо дані та перевіряємо, чи поле орендоване
foreach ($fields as &$field) {
    // Перевіряємо, чи поле орендоване
    $rented_field = array_filter($rented_fields, function ($rented) use ($field) {
        return $rented['field_id'] == $field['id'];
    });

    // Якщо поле орендоване, беремо перший орендар (якщо таких кілька)
    if (!empty($rented_field)) {
        $rented_field = array_values($rented_field);
        $field['is_rented'] = true;
        $field['full_name'] = $rented_field[0]['full_name'];
    } else {
        $field['is_rented'] = false;
        $field['full_name'] = null;
    }
}

$currencyApiUrl = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
$currencyData = json_decode(file_get_contents($currencyApiUrl), true);

$usdRate = 0;
foreach ($currencyData as $currency) {
    if ($currency['cc'] === 'USD') {
        $usdRate = $currency['rate'];
        break;
    }
}

// Отримуємо останню ціну оренди з таблиці land_rent_prices
$rentPriceSql = "SELECT price_per_hectare FROM land_rent_prices ORDER BY updated_at DESC LIMIT 1";
$rentPriceResult = $conn->query($rentPriceSql);
$rentPrice = 0;

if ($rentPriceResult->num_rows > 0) {
    $row = $rentPriceResult->fetch_assoc();
    $rentPrice = $row['price_per_hectare'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оренда земель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/Maps.css">
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrJ7H5qYmz2kqfzhSD0WM-qC56OFm4o8w&libraries=geometry&async"></script>
</head>

<body>
    <?php require('./components/Header/index.php'); ?>

    <div class="headerGap">
        <h2 class="text-center mb-4 hGradient">Карта оренди земель</h2>
        <div>
            <p id="instruction">Клікніть на поле для перегляду інформації.</p>
            <div id="field-info"></div>
        </div>
        <div id="selected-fields">
            <p id="instruction"> Орендуйте поле для відображення інформації</p>
        </div>
        <div id="map"></div>
    </div>

    <script>
        const mapCenter = { lat: 49.016820, lng: 26.152397 };
        const fields = <?php echo json_encode($fields); ?>;
        const usdRate = <?php echo $usdRate; ?>;
        const rentPriceInUAH = <?php echo $rentPrice; ?>;

        const map = new google.maps.Map(document.getElementById("map"), {
            center: mapCenter,
            zoom: 17,
            mapTypeId: "satellite"
        });

        let selectedFields = [];

        function updateSelectedFieldsList() {
            const container = document.getElementById("selected-fields");
            container.innerHTML = "";

            if (selectedFields.length === 0) {
                container.innerHTML = "<p id='instruction'>Орендуйте поле для відображення інформації</p>";
                return;
            }

            const header = document.createElement("h4");
            header.textContent = "Обрані поля";
            container.appendChild(header);

            const table = document.createElement("table");
            table.classList.add("selected-fields-table");

            const thead = document.createElement("thead");
            thead.innerHTML = `
        <tr>
            <th>Назва поля</th>
            <th>Площа (га)</th>
            <th>Ціна (USD)</th>
            <th>Дія</th>
        </tr>
    `;
            table.appendChild(thead);

            const tbody = document.createElement("tbody");

            let totalHectares = 0;
            let totalPrice = 0;

            selectedFields.forEach((field, index) => {
                totalHectares += field.areaInHectares;
                totalPrice += field.totalRentPriceInUSD;

                const tr = document.createElement("tr");
                tr.innerHTML = `
            <td>${field.name}</td>
            <td>${field.areaInHectares.toFixed(2)}</td>
            <td>${field.totalRentPriceInUSD.toFixed(2)}</td>
            <td><button class="remove-btn" onclick="removeField(${index})">&times;</button></td>
        `;
                tbody.appendChild(tr);
            });

            table.appendChild(tbody);

            const tfoot = document.createElement("tfoot");
            tfoot.innerHTML = `
                <tr>
                    <td><b>Разом:</b></td>
                    <td>${totalHectares.toFixed(2)} га</td>
                    <td>${totalPrice.toFixed(2)} USD</td>
                    <td></td>
                </tr>
            `;
            table.appendChild(tfoot);

            container.appendChild(table);

            const confirmBtn = document.createElement("button");
            confirmBtn.classList.add("confirm-btn");
            confirmBtn.id = "confirmOrder";
            confirmBtn.textContent = "Підтвердити замовлення";
            confirmBtn.addEventListener("click", showOrderForm);
            container.appendChild(confirmBtn);
        }


        function removeField(index) {
            const fieldId = selectedFields[index].id;
            const originalField = fields.find(f => f.id === fieldId);

            if (originalField) {
                originalField.polygon.setOptions({ fillColor: "#f0c674" });
            }

            selectedFields.splice(index, 1);
            updateSelectedFieldsList();
        }

        fields.forEach(field => {
            const lat = parseFloat(field.latitude), lng = parseFloat(field.longitude);
            if (isNaN(lat) || isNaN(lng)) return console.error(`Invalid coordinates for field: ${field.name}`);

            const boundaryCoordinates = JSON.parse(field.boundary_coordinates);

            const isRented = field.is_rented;
            const fieldColor = isRented ? "#ff0000" : "#f0c674";

            const fieldPolygon = new google.maps.Polygon({
                paths: boundaryCoordinates,
                strokeColor: fieldColor,
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: fieldColor,
                fillOpacity: 0.35
            });

            field.polygon = fieldPolygon;
            fieldPolygon.setMap(map);

            const marker = new google.maps.Marker({
                position: { lat, lng },
                map,
                title: field.name
            });

            const areaInHectares = google.maps.geometry.spherical.computeArea(fieldPolygon.getPath()) / 10000;
            const totalRentPriceInUSD = rentPriceInUAH * areaInHectares / usdRate;

            function showFieldInfo() {
                document.getElementById("instruction").style.display = "none";
                const container = document.getElementById("field-info");
                container.innerHTML = "";

                const table = document.createElement("table");
                table.classList.add("field-info-table");

                const thead = document.createElement("thead");
                thead.innerHTML = `<tr><th colspan="2">${field.name}</th></tr>`;
                table.appendChild(thead);

                const tbody = document.createElement("tbody");

                const infoRows = {
                    "Площа": `${areaInHectares.toFixed(2)} га`,
                    "Тип землі": field.land_type || 'Відсутньо',
                    "Остання культура": field.last_culture || 'Відсутньо',
                    "Дозволені культури": field.allowed_cultures || 'Відсутньо',
                    "Стан поля": field.field_condition || 'Відсутньо',
                    "Ціна оренди": `${totalRentPriceInUSD.toFixed(2)} USD на рік`
                };

                for (const key in infoRows) {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `<td>${key}</td><td>${infoRows[key]}</td>`;
                    tbody.appendChild(tr);
                }

                if (isRented) {
                    const trRented = document.createElement("tr");
                    trRented.innerHTML = `<td>Орендар</td><td>${field.full_name}</td>`;
                    tbody.appendChild(trRented);

                    const tfoot = document.createElement("tfoot");
                    tfoot.innerHTML = `<tr><td colspan="2" class="rented-text">Поле орендоване</td></tr>`;
                    table.appendChild(tfoot);
                } else {
                    const trBtn = document.createElement("tr");
                    trBtn.innerHTML = `<td colspan="2" style="text-align:center;">
            <button id="rent-btn" class="btn">Орендувати</button>
        </td>`;
                    tbody.appendChild(trBtn);
                }

                table.appendChild(tbody);
                container.appendChild(table);

                if (!isRented) {
                    document.getElementById("rent-btn").addEventListener("click", () =>
                        toggleFieldSelection(field.name, areaInHectares, totalRentPriceInUSD, field.id)
                    );
                }
            }


            function toggleFieldSelection(name, area, price, fieldId) {
                const index = selectedFields.findIndex(f => f.name === name);
                if (index === -1 && selectedFields.length < 8) {
                    selectedFields.push({
                        name,
                        areaInHectares: area,
                        totalRentPriceInUSD: price,
                        id: fieldId
                    });
                } else if (index !== -1) {
                    removeField(index);
                } else {
                    alert("Максимальна кількість вибраних полів - 8");
                }
                updateSelectedFieldsList();
            }

            fieldPolygon.addListener("click", showFieldInfo);
            marker.addListener("click", showFieldInfo);
        });


        function showOrderForm() {
            // Оновлюємо підсумкові значення
            const totalFields = selectedFields.length;
            const totalHectares = selectedFields.reduce((sum, field) => sum + field.areaInHectares, 0);
            const totalPrice = selectedFields.reduce((sum, field) => sum + field.totalRentPriceInUSD, 0);

            // Заповнюємо підсумкові дані
            document.getElementById("totalFields").textContent = totalFields;
            document.getElementById("totalHectares").textContent = totalHectares.toFixed(2) + ' га';
            document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);

            // Показуємо форму
            const modal = new bootstrap.Modal(document.getElementById("order-form-container"));
            modal.show();

            document.getElementById("customer_type").addEventListener("change", function () {
                document.getElementById("companyFields").style.display = this.value === "Юридична особа" ? "block" : "none";
            });
        }

        function submitOrder() {
            const orderData = {
                full_name: document.getElementById("full_name").value,
                customer_type: document.getElementById("customer_type").value,
                company_name: document.getElementById("customer_type").value === "Юридична особа" ? document.getElementById("company_name").value : null,
                company_code: document.getElementById("customer_type").value === "Юридична особа" ? document.getElementById("company_code").value : null,
                customer_phone: document.getElementById("customer_phone").value,
                customer_email: document.getElementById("customer_email").value,
                customer_address: document.getElementById("customer_address").value,
                customer_comment: document.getElementById("customer_comment").value,
                fields: selectedFields.map(field => field.id),
                total_hectares: selectedFields.reduce((sum, field) => sum + field.areaInHectares, 0),
                total_price: selectedFields.reduce((sum, field) => sum + field.totalRentPriceInUSD, 0)
            };

            fetch("admin/process_order.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(orderData)
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Відповідь від сервера:", data);

                    if (data.success) {
                        alert(data.message);
                        closeOrderForm();
                    } else {
                        console.error("Помилка: " + data.message);
                    }
                })
                .catch(error => {
                    console.error("Помилка при оформленні замовлення:", error);
                });
        }

        function closeOrderForm() {
            document.getElementById("order-form-container").remove();
            window.location.href = "index.php";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<!-- Форма для підтвердження замовлення -->
<div id="order-form-container" class="modal fade" tabindex="-1" aria-labelledby="orderFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: black; color: white;">
            <div class="modal-header">
                <h5 class="modal-title" id="orderFormLabel">Підтвердження замовлення</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="full_name" class="form-label">ПІБ:</label>
                    <input type="text" class="form-control" id="full_name" required>
                </div>
                <div class="mb-3">
                    <label for="customer_type" class="form-label">Тип клієнта:</label>
                    <select id="customer_type" class="form-select" required>
                        <option value="Фізична особа">Фізична особа</option>
                        <option value="Юридична особа">Юридична особа</option>
                    </select>
                </div>
                <div id="companyFields" style="display: none;">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Назва компанії:</label>
                        <input type="text" class="form-control" id="company_name">
                    </div>
                    <div class="mb-3">
                        <label for="company_code" class="form-label">Код компанії:</label>
                        <input type="text" class="form-control" id="company_code">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="customer_phone" class="form-label">Телефон:</label>
                    <input type="text" class="form-control" id="customer_phone" required>
                </div>
                <div class="mb-3">
                    <label for="customer_email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="customer_email" required>
                </div>
                <div class="mb-3">
                    <label for="customer_address" class="form-label">Адреса:</label>
                    <input type="text" class="form-control" id="customer_address" required>
                </div>
                <div class="mb-3">
                    <label for="customer_comment" class="form-label">Коментар:</label>
                    <textarea class="form-control" id="customer_comment"></textarea>
                </div>
                <div class="mb-3">
                    <h6>Підсумок:</h6>
                    <table class="table table-dark table-bordered">
                        <tbody>
                            <tr>
                                <td><strong>Кількість полів:</strong></td>
                                <td><span id="totalFields"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Загальна площа:</strong></td>
                                <td><span id="totalHectares"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Загальна вартість:</strong></td>
                                <td>$<span id="totalPrice"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Скасувати</button>
                <button type="button" class="btn btn-primary" onclick="submitOrder()">Оформити</button>
            </div>
        </div>
    </div>
</div>

</html>