<?php
include 'header.php';

require '../php/obj/Database.php';
require '../php/obj/Bill.php';
require '../php/obj/Client.php';
require '../php/contr/BillController.php';
require '../php/obj/Indication.php';
require '../php/obj/IndicationType.php';
require '../php/obj/Price.php';

$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$clientInfo = $client->getById();
$bill = new Bill($conn);
$bills = $bill->getAllByClientId();
$arr = getBillInfo($conn);

$last = $bill->getById($_GET['bill_id']);

$bill_arr = $bill->pay($_GET['bill_id']);

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

            <h1>КВИТАНЦИЯ <?php echo '#' . $_GET['bill_id'] ?></h1>
            <hr>

            <h2>ДАТА ФОРМИРОВАНИЯ КВИТАНЦИИ: <?php echo date('d.m.Y', strtotime($last['DATE'])); ?>
                <br>СТАТУС: <?php echo $last['IS_PAID'] ? 'ОПЛАЧЕНО' : 'НЕ ОПЛАЧЕНО'; ?>
            </h2>

            <table>

                <thead>
                <tr>
                    <th>УСЛУГА</th>
                    <th>ОБЪЕМ</th>
                    <th>ЦЕНА</th>
                </tr>
                </thead>

                <tbody>

                <?php
                foreach ($arr as $row) {
                    echo '<tr>';
                    echo '<td data-label="Услуга">' . $row['NAME'] . '</td>';
                    echo '<td data-label="Объем">' . $row['VALUE'] . '</td>';
                    echo '<td data-label="Цена">' . $row['PRICE'] . '</td>';
                    echo '</tr>';
                }
                ?>

                </tbody>

            </table>

            <div class="error">
                <?php
                if (!empty($bill_arr['message'])) {
                    echo $bill_arr['message'];
                }
                ?>
            </div>

            <hr>

            <form method="post">
                <input type="submit" class="registerbtn" value="ОПЛАТИТЬ" name="pay">
            </form>

            <button type="submit" class="registerbtn"><a style="color: white"
                                                         href="bill.php?id=<?php echo $_GET['bill_id']; ?>">КВИТАНЦИЯ
                    PDF</a></button>


        </div>

    </section>
</main>

</body>

</html>