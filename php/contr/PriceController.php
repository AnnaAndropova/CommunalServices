<?php

function update_price($conn)
{
    if (isset($_POST['save'])) {
        for ($i = 1; $i < 4; $i++) {
            if (empty($_POST['value' . $i . '']) || empty($_POST['price' . $i . ''])) {
                return [
                    'message' => "Заполните все поля"
                ];
            }
            if (($_POST['value' . $i . ''] <= 0) || ($_POST['price' . $i . ''] <= 0)) {
                return [
                    'message' => "Введите действительные значения тарифов"
                ];
            }
        }
        for ($i = 1; $i < 4; $i++) {
            $price = new Price($conn, $i, $_POST['value' . $i . ''], $_POST['price' . $i . '']);
            $price->update();
        }
        header("Location: ../front/adminfirstpage.php");
    }
}

