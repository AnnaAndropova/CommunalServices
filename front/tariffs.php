<?php
include 'main_header.php';

require '../php/obj/Database.php';
require '../php/obj/Price.php';
require '../php/obj/IndicationType.php';
$db = new Database();
$conn = $db->getConnection();
$price = new Price($conn);
$arr = $price->getAll();
?>


<main class="main">
    <section class="intro">
        <div class="wrapper">

            <h1 class="intro_title">
                ВАШ ДОМ – НАША ЗАБОТА
            </h1>

            <div class="button">
                <a href="addresses.php" class="floating-button">АДРЕСА</a>
                <a href="tariffs.php" class="floating-button">ТАРИФЫ</a>
                <a href="reference.php" class="floating-button">СПРАВКА</a>
            </div>

            <h2 class="outro_title">
                <div class="table-wrap">

                    <table>
                        <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Объем потребления</th>
                            <th>Цена за 1 ед.</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php
                        foreach ($arr as $row) {
                            $ind = new IndicationType($conn);
                            $i = $ind->getById($row['TYPE_ID']);
                            echo '<tr>';
                            echo '<td data-label="Услуга">' . $i['NAME'] . '</td>';
                            echo '<td data-label="Объем">' . $row['VALUE'] . '</td>';
                            echo '<td data-label="Цена">' . $row['PRICE'] . ' руб</td>';
                            echo '</tr>';
                        }
                        ?>

                        </tbody>

                    </table>

                </div>
            </h2>

        </div>
    </section>
</main>

</body>

</html>