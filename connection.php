<?php
function OpenCon()
{
    $host = "127.0.0.1:50525";
    $user = "azure";
    $pass = "6#vWHD_$";
    $db = "communal_services";
    $conn = new mysqli($host, $user, $pass,$db) or die("Connect failed: %s\n". $conn -> error);

    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}
