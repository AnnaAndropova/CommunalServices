<?php

include 'header.php';

require '../php/obj/Database.php';
require '../php/obj/Bill.php';
require '../php/obj/Client.php';
require '../php/obj/Address.php';
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
?>


<main class="main account-page">

    <section class="bills">
        <div class="block">

            <h1>КВИТАНЦИИ</h1>
            <hr>

            <!-- Ссылка на иконки-->
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

            <table>

                <?php
                foreach ($bills as $row) {
                    echo '<tr>';
                    echo '<td><a href="ticket.php?bill_id=' . $row['ID'] . '">' . date('d.m.Y', strtotime($row['DATE'])) . '</a></td>';
                    if ($row['IS_PAID']) {
                        echo '<td><i class="fa fa-check"></i></td>';
                    } else {
                        echo '<td><i class="fa fa-remove"></i></td>';
                    }
                    echo '</tr>';
                }
                ?>

            </table>

            <hr>

            <form action="help.php">
                <button type="submit" class="registerbtn">ОБРАЩЕНИЕ</button>
            </form>

            <form action="reading.php">
                <button type="submit" class="registerbtn">ПОКАЗАНИЯ ИПУ</button>
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
                <input type="number" placeholder="Выберите номер дома" name="house" required
                       value="<?php echo $address->house ?>">

                <label for="flat"><b>КВАРТИРА</b></label>
                <input type="number" placeholder="Выберите номер квартиры" name="apartment" required
                       value="<?php echo $address->apartment ?>">

                <label for="resident"><b>КОЛИЧЕСТВО ЖИЛЬЦОВ</b></label>
                <input type="number" placeholder="Выберите количество проживающих" name="tenant_count" required
                       value="<?php echo $clientInfo['TENANT_COUNT'] ?>">

                <div class="error">
                    <?php
                    if (!empty($arr['message'])) {
                        echo $arr['message'];
                    }
                    ?>
                </div>

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