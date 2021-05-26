<?php

class Database
{
    public $conn;

    private $host = "127.0.0.1:50354";
    private $db_name = "communal_services";
    private $username = "azure";
    private $password = "6#vWHD_$";

    /*LOCALHOST
    private $host = "localhost";
    private $db_name = "COMMUNAL_SERVICES";
    private $username = "root";
    private $password = "root";*/

    public function getConnection()
    {

        $this->conn = null;

            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

        return $this->conn;
    }
}