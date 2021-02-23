<?php
require "connection.php";

$link = OpenCon();
$a = 2;
$query = "SELECT count(*) FROM test";
$test = mysqli_query($link, $query);
$row = mysqli_fetch_row($test);
echo '<p>= '.$row[0].'</p>';
echo 'hi';
