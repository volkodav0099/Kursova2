<?php
require('./components/Header/index.php');
require_once('config.php');
?>

<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Працівники</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<section class="employee-cards">
        <?php
        $sql = "SELECT * FROM employees";
        $result = mysqli_query($conn, $sql);

        while ($employee = mysqli_fetch_assoc($result)):
            ?>
            <div class="employee-card">
                <img src="<?php echo $employee['pfp_pic']; ?>" alt="<?php echo $employee['name']; ?> <?php echo $employee['surname']; ?>">
                <div class="employee-info">
                    <h2><?php echo $employee['name']; ?> <?php echo $employee['surname']; ?></h2>
                    <p><strong>По-батькові:</strong> <?php echo $employee['middle_name']; ?></p>
                    <p><strong>Дата народження:</strong> <?php echo $employee['date_of_birth']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
</section>
<div class="boots_back">
    <a href="index.php">Повернутись на головну</a>
</div>
</body>
</html>
