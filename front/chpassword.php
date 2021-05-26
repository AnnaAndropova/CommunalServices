<?php
include 'header.php';

require '../php/obj/Database.php';
require '../php/obj/Bill.php';
require '../php/obj/Client.php';
$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$clientInfo = $client->getById();


$bill = new Bill($conn);
$bills = $bill->getAllByClientId();
$arr = $client->changePassword();

?>
<main class="main">
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
                    echo '<td><a href="ticket.php?bill_id=' . $row['ID'] . '">' . $row['DATE'] . '</a></td>';
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

            <h1>ИЗМЕНЕНИЕ ПАРОЛЯ</h1>
            <hr>

            <form method="post">

                <label><b>ТЕКУЩИЙ ПАРОЛЬ</b></label>
                <input type="password" name="old_password" required>

                <label><b>НОВЫЙ ПАРОЛЬ</b></label>
                <input type="password" name="new_password" required>

                <label><b>ПОВТОРИТЕ ПАРОЛЬ</b></label>
                <input type="password" name="repeat_password" required>


                <div class="error">
                    <?php
                    if (!empty($arr['message'])) {
                        echo $arr['message'];
                    }
                    ?>
                </div>

                <hr>

                <input type="submit" class="registerbtn" value="СОХРАНИТЬ" name="password">
            </form>

        </div>

    </section>
</main>

</body>

</html>