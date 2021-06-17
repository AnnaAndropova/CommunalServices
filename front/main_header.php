<?php
session_start();
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
    
 <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter81056281 = new Ya.Metrika({
                    id:81056281,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
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
<noscript><div><img src="https://mc.yandex.ru/watch/81056281" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    
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

            <?php
            if (isset($_SESSION['id'])) {
                echo '<nav class="header_nav">

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

            </nav>';
            } else if ($_SESSION['isAdmin']) {
                echo '<nav class="header_nav">

                <ul class="header_list">

                    <li class="header_item">
                        <a href="../index.php" class="header_link">ГЛАВНАЯ</a>
                    </li>

                    <li class="header_item">
                        <a href="adminfirstpage.php" class="header_link">КАБИНЕТ</a>
                    </li>

                    <li class="header_item">
                        <a href="authorization.php" class="header_link">ВЫЙТИ</a>
                    </li>

                </ul>

            </nav>';
            } else {
                echo '<nav class="header_nav">
                    <ul class="header_list">

                        <li class="header_item">
                            <a href="../index.php" class="header_link">ГЛАВНАЯ</a>
                        </li>

                        <li class="header_item">
                            <a href="authorization.php" class="header_link">ВОЙТИ</a>
                        </li>

                    </ul>
                </nav>';
            }
            ?>

        </div>
    </div>
</header>
