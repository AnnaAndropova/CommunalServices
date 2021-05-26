<?php
session_start();
require '../php/obj/Database.php';
require '../php/obj/Bill.php';
require '../php/obj/Client.php';
require '../php/obj/Address.php';
require '../php/obj/IndicationType.php';
require '../php/obj/Indication.php';
require '../php/contr/BillController.php';
require '../php/obj/Price.php';
include "../vendor/tecnickcom/tcpdf/tcpdf_import.php";

$db = new Database();
$conn = $db->getConnection();

$bill = new Bill($conn);
$client = new Client($conn);
$address = new Address($conn);
$indicationType = new IndicationType($conn);
$indication = new Indication($conn);
$price = new Price($conn);

$arr = getBillInfo1($conn);
$cl = $client->getById();
$type = $indicationType->getAll();
$last = $bill->getById($_GET['id']);
$ind = $indication->getAllByDate($last['DATE']);
$p = $price->getAll();

class MYPDF_C extends TCPDF
{
//Page header
    public function Header()
    {
    }

// Page footer
    public function Footer()
    {
    }
}

// create new PDF document
$pdf = new MYPDF_C(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// ---------------------------------------------------------

// РАССТОЯНИЯ В СМ, ТЕКСТ В ПИКС

$pdf->AddPage();
$pdf->setFontStretching(100);
$pdf->SetFont('freesans', 'B', 9);
$pdf->Text(20, 17, 'ИЗВЕЩЕНИЕ');
$pdf->Text(20, 102, 'КВИТАНЦИЯ');

$pdf->SetFont('freesans', 'N', 11);
$pdf->Text(165, 17, '№ '.$last['ID']);

$pdf->SetFont('freesans', 'N', 8);
$pdf->Text(54, 22, 'Платежный документ для внесения платы за предоставление коммунальных услуг');
$pdf->Text(54, 26, 'Получатель платежа ВКУ г. Воронеж');

$pdf->SetFont('freesans', 'N', 11);
$pdf->Text(64, 30, 'Расчетный период ' . date('d.m.Y', strtotime($last['DATE'] . '-1 month')) . ' - ' . date('d.m.Y', strtotime($last['DATE'])));

$pdf->SetFont('freesans', 'B', 11);
$pdf->Text(54, 34, 'Л/счет ' . ($_SESSION['id'] * 12345 + $_SESSION['id'] * 50));

$pdf->SetFont('freesans', 'N', 8);
$pdf->Text(54, 40, 'Ф.И.О. ' . $cl['SURNAME'] . ' ' . $cl['NAME'] . ' ' . $cl['PATRONYMIC']);
$address->getById($cl['ADDRESS_ID']);
$pdf->Text(54, 44, 'Адрес ' . $address->street . ', д.' . $address->house . ' - ' . $address->apartment);

$pdf->SetFont('freesans', 'BU', 11);
$pdf->Text(84, 48, 'К оплате ' . $last['SUM'] . ' руб.');

$pdf->SetFont('freesans', 'N', 8);
$pdf->Text(54, 53, 'Уважаемые абоненты! занесите текущие показания приборов учета в таблицу');
$pdf->Text(54, 56, 'и не забудьте указать в своем личном кабинете на сайте УК');

$pdf->Text(140, 63, 'Показания ИПУ');
$pdf->Text(70, 68, 'Услуга');
$pdf->Text(115, 68, 'Предыдущие');
$pdf->Text(165, 68, 'Текущие');

$i = 0;
foreach ($type as $t) {
    $pdf->Text(55, 72 + $i, $t['NAME']);
    $i += 5.5;
}

$i = 0;
if (!empty($ind)) {
    foreach ($ind as $row) {
        $pdf->Text(120, 72 + $i, $row['VALUE']);
        $i += 5.5;
    }
} else {
    for ($j = 0; $j < 3; $j++) {
        $pdf->Text(120, 72 + $i, 0);
        $i += 5.5;
    }
}

$pdf->SetFont('freesans', 'B', 11);
$pdf->Text(54, 92, 'Оплачено __________ руб.');

$pdf->SetFont('freesans', 'N', 11);
$pdf->Text(140, 92, 'Подпись __________');

$pdf->Text(54, 102, 'Информация для внесения платы получателю платежа:');

$pdf->SetFont('freesans', 'N', 8);
$pdf->Text(54, 108, 'Получатель платежа ВКУ г. Воронеж, Университетская пл. 1');
$pdf->Text(54, 112, 'Сайт communalservices.azurewebsites.net');
$pdf->Text(54, 116, 'Р/С 123456');
$pdf->Text(54, 120, 'ИНН 1234 КПП 1234');
$pdf->Text(54, 124, 'в ОТДЕЛЕНИИ Г ВОРОНЕЖА № 123 ПАО СБЕРБАНК');

$pdf->SetFont('freesans', 'N', 11);
$pdf->Text(64, 128, 'Расчетный период ' . date('d.m.Y', strtotime($last['DATE'] . '-1 month')) . ' - ' . date('d.m.Y', strtotime($last['DATE'])));

$pdf->SetFont('freesans', 'B', 11);
$pdf->Text(54, 132, 'Л/счет ' . ($_SESSION['id'] * 12345 + $_SESSION['id'] * 50));

$pdf->SetFont('freesans', 'N', 8);
$pdf->Text(54, 138, 'Ф.И.О. плательщика ' . $cl['SURNAME'] . ' ' . $cl['NAME'] . ' ' . $cl['PATRONYMIC']);
$pdf->Text(54, 142, 'Кол-во человек ' . $cl['TENANT_COUNT']);

$pdf->Text(70, 148, 'Услуга');
$pdf->Text(112, 148, 'Объем');
$pdf->Text(145, 148, 'Тариф, руб.');
$pdf->Text(175, 148, 'Начислено');

$i = 0;
foreach ($arr as $row) {
    $pdf->Text(115, 152 + $i, $row['VALUE']);
    $pdf->Text(180, 152 + $i, $row['PRICE']);
    $i += 5.5;
}

$i = 0;
foreach ($p as $row) {
    $pdf->Text(150, 152 + $i, $row['PRICE']);
    $i += 5.5;
}

$i = 0;
foreach ($type as $t) {
    $pdf->Text(55, 152 + $i, $t['NAME']);
    $i += 5.5;
}

$pdf->SetFont('freesans', 'N', 10);
$pdf->Text(160, 170, 'Итого ' . $last['SUM'] . ' руб.');

$pdf->SetFont('freesans', 'BU', 11);
$pdf->Text(84, 178, 'К оплате ' . $last['SUM'] . ' руб.');

$pdf->SetFont('freesans', 'N', 8);
$pdf->Text(54, 183, 'В случае непредоставления показаний индивидуальных приборов учета за расчетный период,');
$pdf->Text(54, 186, 'плата определяется по нормативам потребления');

// set style for barcode
$style = array(
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$code = 'Благодарим за своевременную оплату';

// QRCODE,M : QR-CODE Medium error correction
$pdf->write2DBarcode($code, 'QRCODE,M', 13, 25, 35, 35, $style, 'N');


//$pdf->write2DBarcode($code, 'PDF417', 80, 90, 0, 20, $style, 'N');


$pdf->SetDrawColor(0);
$pdf->SetLineWidth(0.3);

$pdf->Line(197, 15, 197, 195);
$pdf->Line(9, 15, 9, 195);
//$pdf->Line(9, 180, 197, 180);
$pdf->Line(9, 100, 197, 100);
$pdf->Line(50.7, 15, 50.7, 195);

$pdf->SetLineWidth(0.5);

$pdf->Line(50.7, 62, 197, 62);
$pdf->Line(50.7, 67, 197, 67);
$pdf->Line(50.7, 72, 197, 72);
$pdf->Line(50.7, 77, 197, 77);
$pdf->Line(50.7, 82, 197, 82);
$pdf->Line(50.7, 87, 197, 87);

$pdf->Line(100, 62, 100, 87);
$pdf->Line(150, 67, 150, 87);

$pdf->Line(50.7, 147, 197, 147);
$pdf->Line(50.7, 152, 197, 152);
$pdf->Line(50.7, 157, 197, 157);
$pdf->Line(50.7, 162, 197, 162);
$pdf->Line(50.7, 167, 197, 167);

$pdf->Line(100, 147, 100, 167);
$pdf->Line(170, 147, 170, 167);
$pdf->Line(137, 147, 137, 167);

//Создаем реальный файл PDF с именем клиента и номером заказа

//Папка, в которую пишем, должна иметь доступ 777

$id = $_GET['id'];
$pdf->Output("bill.pdf", "I");


//И открываем его в текущем окне

$URL = 'http://' . $_SERVER['HTTP_HOST'] . 'bill.pdf';
header("Location: $URL");

