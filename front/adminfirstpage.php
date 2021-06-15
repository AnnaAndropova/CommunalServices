<?php
include 'admin_header.php';

require '../php/obj/Database.php';
require '../php/obj/Price.php';
require '../php/contr/PriceController.php';
require '../php/obj/IndicationType.php';
require '../php/obj/Request.php';
require '../php/obj/Client.php';

$db = new Database();
$conn = $db->getConnection();
$price = new Price($conn);
$prices = $price->getAll();
$indType = new IndicationType($conn);
$request = new Request($conn);
$client = new Client($conn);

$allReq = $request->getAll();

$arr = update_price($conn);
?>
<main class="main">
    <section class="bills">

        <div class="block">

            <h1>ОБРАЩЕНИЯ</h1>
            <hr>

            <?php
            foreach ($allReq as $row) {
                echo '<h2>№: ' . $row['ID'];
                echo '<br>ДАТА: ' . date('d.m.Y', strtotime($row['DATE']));
                $cl = $client->getById1($row['CLIENT_ID']);
                echo '<br>КЛИЕНТ: ' . $cl['SURNAME'] . ' ' . substr($cl['NAME'], 0, 2) . '. '
                    . substr($cl['PATRONYMIC'], 0, 2) . '.';
                echo '</h2>';
                if ($row['IS_CHECKED'] == 0) {
                    echo '
                <button type="submit" class="registerbtn"><a style="color: white" href="adminsecondpage.php?id=' . $row['ID'] . '">ПРОСМОТРЕТЬ</a></button>';
                } else {
                    echo '
                <button type="submit" class="registerbtn"><a style="color: white" href="adminsecondpage.php?id=' . $row['ID'] . '">ПРОСМОТРЕНО</a></button>';
                }
            }
            ?>

        </div>

        <div class="block">

            <h1>ТАРИФЫ</h1>
            <hr>

            <form method="post">

                <?php
                $i = 1;
                foreach ($prices as $row) {
                    $type = $indType->getById($row['TYPE_ID']);
                    echo '<h1>' . $type['NAME'] . '</h1>';
                    echo '<label><b>ОБЪЕМ</b></label>';
                    echo '<input type="number" min="1" name="value' . $i . '" value="' . $row['VALUE'] . '">';
                    echo '<label for="price"><b>ЦЕНА</b></label>';
                    echo '<input type="number" min="1" name="price' . $i . '" value="' . $row['PRICE'] . '">';
                    $i++;
                }
                ?>

                <div class="error">
                    <?php
                    if (!empty($arr['message'])) {
                        echo $arr['message'];
                    }
                    ?>
                </div>

                <hr>

                <input type="submit" class="registerbtn" value="СОХРАНИТЬ" name="save">
            </form>

        </div>

    </section>
</main>

</body>

</html>