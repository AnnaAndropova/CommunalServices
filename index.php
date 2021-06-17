<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ВКУ</title>

    <link rel="stylesheet" href="front/css/reset.css">
    <link rel="stylesheet" href="front/css/fonts.css">
    <link rel="stylesheet" href="front/css/style.css">
    
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter81054280 = new Ya.Metrika({
                    id:81054280,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/81054280" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    
</head>

<body>
<header class="header">
    <div class="wrapper">
        <div class="header_wrapper">

            <div class="header_logo">
                <a href="index.php" class="header_logo-link">
                    <div class="text_logo">
                        <div>
                            <img src="front/img/svg/logo.svg" alt="ВКУ" class="header_logo-pic">
                        </div>
                        <div>
                            <span class="light_logo">ВОРОНЕЖ КОММУНАЛЬНЫЕ УСЛУГИ</span><br>
                            ВКУ
                        </div>
                    </div>
                </a>
            </div>

            <?php
            if (isset($_SESSION['id'])) {
                echo '<nav class="header_nav">

                <ul class="header_list">

                    <li class="header_item">
                        <a href="index.php" class="header_link">ГЛАВНАЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="front/account.php" class="header_link">КАБИНЕТ</a>
                    </li>

                    <li class="header_item">
                        <a href="front/reading.php" class="header_link">ПОКАЗАНИЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="front/authorization.php" class="header_link">ВЫЙТИ</a>
                    </li>

                </ul>

            </nav>';
            } else if ($_SESSION['isAdmin']) {
                echo '<nav class="header_nav">

                <ul class="header_list">

                    <li class="header_item">
                        <a href="index.php" class="header_link">ГЛАВНАЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="front/adminfirstpage.php" class="header_link">КАБИНЕТ</a>
                    </li>

                    <li class="header_item">
                        <a href="front/authorization.php" class="header_link">ВЫЙТИ</a>
                    </li>

                </ul>

            </nav>';
            } else {
                echo '<nav class="header_nav">
                    <ul class="header_list">

                        <li class="header_item">
                            <a href="index.php" class="header_link">ГЛАВНАЯ</a>
                        </li>

                        <li class="header_item">
                            <a href="front/authorization.php" class="header_link">ВОЙТИ</a>
                        </li>

                    </ul>
                </nav>';
            }
            ?>

        </div>
    </div>
</header>


<main class="main">
    <section class="intro">
        <div class="wrapper">

            <h1 class="intro_title">
                ВАШ ДОМ – НАША ЗАБОТА
            </h1>

            <div class="button">
                <a href="front/addresses.php" class="floating-button">АДРЕСА</a>
                <a href="front/tariffs.php" class="floating-button">ТАРИФЫ</a>
                <a href="front/reference.php" class="floating-button">СПРАВКА</a>
            </div>

        </div>
    </section>
</main>

</body>

</html>
