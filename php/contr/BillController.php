<?php
require 'vendor/autoload.php';

function getBillInfo($conn)
{
    if (isset($_GET['bill_id'])) {
        $bill = new Bill($conn);
        $price = new Price($conn);
        $last = $bill->getAllFromId($_GET['bill_id']);
        if (count($last) > 1) {
            $ind = new Indication($conn);
            $indL1 = $ind->getById($last[0]['INDICATION1_ID']);
            $indP1 = $ind->getById($last[1]['INDICATION1_ID']);
            $value = $indL1['VALUE'] - $indP1['VALUE'];
            $p = $price->getByTypeId($indL1['TYPE_ID']);
            $arr[1] = array("VALUE" => $value,
                "PRICE" => $value * $p['PRICE']);
            $indL2 = $ind->getById($last[0]['INDICATION2_ID']);
            $indP2 = $ind->getById($last[1]['INDICATION2_ID']);
            $value = $indL2['VALUE'] - $indP2['VALUE'];
            $p = $price->getByTypeId($indL2['TYPE_ID']);
            $arr[2] = array("VALUE" => $value,
                "PRICE" => $value * $p['PRICE']);
            $indL3 = $ind->getById($last[0]['INDICATION3_ID']);
            $indP3 = $ind->getById($last[1]['INDICATION3_ID']);
            $value = $indL3['VALUE'] - $indP3['VALUE'];
            $p = $price->getByTypeId($indL3['TYPE_ID']);
            $arr[3] = array("VALUE" => $value,
                "PRICE" => $value * $p['PRICE']);
        } else {
            $ind = new Indication($conn);
            $indL1 = $ind->getById($last[0]['INDICATION1_ID']);
            $value = $indL1['VALUE'];
            $p = $price->getByTypeId($indL1['TYPE_ID']);
            $arr[1] = array("VALUE" => $value,
                "PRICE" => $value * $p['PRICE']);
            $indL2 = $ind->getById($last[0]['INDICATION2_ID']);
            $value = $indL2['VALUE'];
            $p = $price->getByTypeId($indL2['TYPE_ID']);
            $arr[2] = array("VALUE" => $value,
                "PRICE" => $value * $p['PRICE']);
            $indL3 = $ind->getById($last[0]['INDICATION3_ID']);
            $value = $indL3['VALUE'];
            $p = $price->getByTypeId($indL3['TYPE_ID']);
            $arr[3] = array("VALUE" => $value,
                "PRICE" => $value * $p['PRICE']);
        }
        return $arr;

    }
}

