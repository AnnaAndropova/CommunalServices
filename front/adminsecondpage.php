<?php
include 'admin_header.php';

require '../php/obj/Database.php';
require '../php/obj/Price.php';
require '../php/contr/PriceController.php';
require '../php/obj/IndicationType.php';
require '../php/obj/Request.php';
require '../php/obj/Client.php';
require '../php/obj/Indication.php';

$db = new Database();
$conn = $db->getConnection();
$price = new Price($conn);
$prices = $price->getAll();
$indType = new IndicationType($conn);
$request = new Request($conn);
$client = new Client($conn);
$ind = new Indication($conn);

$req = $request->getById();

$allReq = $request->getAll();

$request->deny();
$request->accept();

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

            <h1>ИЗМЕНЕНИЯ</h1>
            <hr>

            <h2>ДАТА: <?php echo date('d.m.Y', strtotime($req['DATE'])) ?>
                <br>КЛИЕНТ:
                <?php
                $cl = $client->getById1($req['CLIENT_ID']);
                echo $cl['SURNAME'] . ' ' . substr($cl['NAME'], 0, 2) . '.
                     ' . substr($cl['PATRONYMIC'], 0, 2) . '. ';
                ?>
                <br>ВИД ПОКАЗАНИЯ:
                <?php
                $type = $indType->getById($req['INDICATION_TYPE_ID']);
                echo $type['NAME'];
                ?>
            </h2>

            <?php
            $lastInd = $ind->getLastByClientId1($req['CLIENT_ID'], $type['ID']);
            ?>

            <form method="post">
                <label for="oldreading"></label>
                <input type="text" name="old" value="<?php echo $lastInd['VALUE'] ?>" required readonly>

                <label for="newreading"></label>
                <input type="text" name="new" value="<?php echo $req['VALUE'] ?>" required readonly>

                <h2>
                    Последний запрос на изменение показаний:
                    <?php
                    $last = $request->getLastByClientId($req['CLIENT_ID']);
                    echo date('d.m.Y', strtotime($last['DATE']));
                    ?>
                </h2>

                <?php
                if ($req['IS_CHECKED'] == 1) {
                    echo '<button style="background-color: #636364" type="submit" class="registerbtn">ОТКЛОНИТЬ</button>
                <button style="background-color: #636364"  type="submit" class="registerbtn">ПОДТВЕРДИТЬ</button>';
                } else {
                    echo '<button type="submit" class="registerbtn" name="deny">ОТКЛОНИТЬ</button>
                <button type="submit" class="registerbtn" name="accept">ПОДТВЕРДИТЬ</button>';
                }
                ?>


            </form>

        </div>

    </section>
</main>

</body>

</html>