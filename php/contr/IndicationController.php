<?php

function add_indication($conn)
{
    if (isset($_POST['SOME_ARR'])) {

        $bill = new \Bill($conn);
        $dateBill = $bill->getLastByClientId();

        $indication = new \Indication($conn);
        $dateInd = $indication->getLastByClientId();
        if ($dateBill != false) {
            if ($dateInd != false && $dateInd >= $dateBill) {
                return [
                    'message' => 'Вы уже передали показания за текущий расчетный период!'
                ];
            }
        } else if ($dateInd != false) {
            return [
                'message' => 'Вы уже передали показания за текущий расчетный период!'
            ];
        }
        for ($i = 1; $i < 4; $i++) {
            if (empty($_POST[$i])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else if ($_POST[$i] < 0) {
                return [
                    'message' => "Введите действительные значение"
                ];
            }
        }

        for ($i = 1; 4; $i++) {
            $indication = new Indication($conn, $_SESSION['id'], $i, $_POST[$i]);
            $indication->create();
        }
    }
}
