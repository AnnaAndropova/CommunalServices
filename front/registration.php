<?php
require '../php/obj/Database.php';
require '../php/obj/Client.php';
require '../php/obj/Address.php';

$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$arr = $client->create();
$address = new Address($conn);
$allAddress = $address->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Воронеж. Коммунальные услуги</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<header class="header">
    <div class="wrapper">
        <div class="header_wrapper">

            <div class="header_logo">
                <a href="../index.php" class="header_logo-link">
                    <img src="img/svg/logo.svg" alt="ВКУ" class="header_logo-pic">ВКУ
                </a>
            </div>

            <nav class="header_nav">
                <ul class="header_list">

                    <li class="header_item">
                        <a href="../index.php" class="header_link">ГЛАВНАЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="authorization.php" class="header_link">ВОЙТИ</a>
                    </li>

                </ul>
            </nav>

        </div>
    </div>
</header>

<main class="main">
    <section class="bills">
        <div class="container">

            <h1>РЕГИСТРАЦИЯ</h1>
            <hr>

            <form method="post">

                <label for="surname"><b>ФАМИЛИЯ</b></label>
                <input type="text" name="surname" required>

                <label for="name"><b>ИМЯ</b></label>
                <input type="text" name="name" required>

                <label for="patronymic"><b>ОТЧЕСТВО</b></label>
                <input type="text" name="patronymic" required>

                <label for="street"><b>УЛИЦА</b></label>
                <select class="look" name="street">
                    <?php
                    foreach ($allAddress as $row) {
                        echo '<option value="' . $row['STREET'] . '">' . $row['STREET'] . '</option>';
                    }
                    ?>
                </select>

                <label for="house"><b>ДОМ</b></label>
                <input type="number" placeholder="Выберите номер дома" name="house" required>

                <label for="apartment"><b>КВАРТИРА</b></label>
                <input type="number" placeholder="Выберите номер квартиры" name="apartment" required>

                <label for="tenant_count"><b>КОЛИЧЕСТВО ЖИЛЬЦОВ</b></label>
                <input type="number" placeholder="Выберите количество проживающих" name="tenant_count" required>

                <label for="login"><b>ЛОГИН</b></label>
                <input type="text" name="login" required>

                <label for="password"><b>ПАРОЛЬ</b></label>
                <input type="password" name="password" required>


                <div class="error">
                    <?php
                    if (!empty($arr['message'])) {
                        echo $arr['message'];
                    }
                    ?>
                </div>

                <hr>

                <input type="submit" class="registerbtn" value="ЗАРЕГИСТРИРОВАТЬСЯ" name="reg">
            </form>

        </div>
    </section>
</main>

</body>

</html>