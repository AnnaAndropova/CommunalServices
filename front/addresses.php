<?php
include 'main_header.php';

require '../php/obj/Database.php';
require '../php/obj/Address.php';
$db = new Database();
$conn = $db->getConnection();
$address = new Address($conn);
$arr = $address->getAll();
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

            <h2 class="outro_title">АДРЕСА</h2 class="outro_title">
            <p class="center">
                <?php
                foreach ($arr as $row) {
                    echo $row['STREET'] . '<br>';
                    $house = $address->getByStreet($row['STREET']);
                    foreach ($house as $row1) {
                        echo 'дом ' . $row1['HOUSE'] . '<br>';
                    }
                    echo '<br>';
                }
                ?>
            </p>

        </div>
    </section>
</main>

</body>

</html>