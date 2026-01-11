<?php
    header('Content-Type: application/json');

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "brovar";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["error" => "Помилка підключення: " . $conn->connect_error]));
    }

    $sql = "SELECT name, boundary_coordinates FROM fields";
    $result = $conn->query($sql);

    $fields = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $fields[] = $row;
        }
    }

    $conn->close();

    echo json_encode($fields);
?>
