<?php
include 'header.php';

require '../php/obj/Database.php';
require '../php/obj/Bill.php';
require '../php/obj/Indication.php';
require '../php/obj/IndicationType.php';
require '../php/obj/Client.php';
require '../php/obj/Address.php';
require '../php/contr/IndicationController.php';
$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$clientInfo = $client->getById();
$address = new Address($conn);
$address->getById($clientInfo['ADDRESS_ID']);
$bill = new Bill($conn);
$bills = $bill->getAllByClientId();
$arr = $client->changeData();
$allAddress = $address->getAll();
$indType = new IndicationType($conn);
$types = $indType->getAll();
$arrAdd = add_indication($conn);
?>

<main class="main">
    <section class="bills">

        <div class="block">

            <h1>ПОКАЗАНИЯ ИПУ</h1>
            <hr>

            <form method="post">

                <?php
                foreach ($types as $type) {
                    echo '<label><b>' . $type['NAME'] . '</b></label>';
                    echo '<input type="number" min="1" name="' . $type['ID'] . '" required>';
                }
                ?>

                <div class="error">
                    <?php
                    if (!empty($arrAdd['message'])) {
                        echo $arrAdd['message'];
                    }
                    ?>
                </div>

                <hr>


                <input type="submit" class="registerbtn" value="ОТПРАВИТЬ" name="add">
            </form>

        </div>

        <div class="block">

            <h1>ДАННЫЕ ПОЛЬЗОВАТЕЛЯ</h1>
            <hr>

            <form method="post">
                <label for="login"><b>ЛОГИН</b></label>
                <input type="text" name="login" required value="<?php echo $clientInfo['LOGIN'] ?>" readonly>

                <label for="street"><b>УЛИЦА</b></label>
                <select class="look" name="street">
                    <?php
                    foreach ($allAddress as $row) {
                        $a = new Address($conn);
                        $a->getById($clientInfo['ADDRESS_ID']);
                        if ($row['STREET'] == $a->street) {
                            echo '<option selected value="' . $row['STREET'] . '">' . $row['STREET'] . '</option>';
                        } else {
                            echo '<option value="' . $row['STREET'] . '">' . $row['STREET'] . '</option>';
                        }
                    }
                    ?>
                </select>

                <label for="house"><b>ДОМ</b></label>
                <input type="number" placeholder="Выберите номер дома" name="house" min="1" required
                       value="<?php echo $address->house ?>">

                <label for="flat"><b>КВАРТИРА</b></label>
                <input type="number" placeholder="Выберите номер квартиры" name="apartment" min="1" required
                       value="<?php echo $address->apartment ?>">

                <label for="resident"><b>КОЛИЧЕСТВО ЖИЛЬЦОВ</b></label>
                <input type="number" placeholder="Выберите количество проживающих" name="tenant_count" min="1" required
                       value="<?php echo $clientInfo['TENANT_COUNT'] ?>">

                <?php
                if (!empty($arr['message'])) {
                    echo $arr['message'];
                }
                ?>

                <hr>

                <input type="submit" class="registerbtn" name="change" value="СОХРАНИТЬ">
            </form>

            <form action="chpassword.php">
                <button type="submit" class="registerbtn">ИЗМЕНИТЬ ПАРОЛЬ</button>
            </form>

        </div>

    </section>
</main>

</body>

</html>