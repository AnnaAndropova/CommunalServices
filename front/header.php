<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ВКУ</title>
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
                    <div class="text_logo">
                        <div>
                            <img src="img/svg/logo.svg" alt="ВКУ" class="header_logo-pic">
                        </div>
                        <div>
                            <span class="light_logo">ВОРОНЕЖ КОММУНАЛЬНЫЕ УСЛУГИ</span><br>
                            ВКУ
                        </div>
                    </div>
                </a>
            </div>

            <nav class="header_nav">

                <ul class="header_list">

                    <li class="header_item">
                        <a href="../index.php" class="header_link">ГЛАВНАЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="account.php" class="header_link">КАБИНЕТ</a>
                    </li>

                    <li class="header_item">
                        <a href="reading.php" class="header_link">ПОКАЗАНИЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="authorization.php" class="header_link">ВЫЙТИ</a>
                    </li>

                </ul>

            </nav>

        </div>

    </div>
</header>

