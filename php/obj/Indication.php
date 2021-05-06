<?php
require 'vendor/autoload.php';

class Indication
{
    public $client_id, $date, $type_id, $value;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'INDICATION';
        $args = func_get_args();
        $cnt = func_num_args();
        switch ($cnt) {
            case 1:
                $this->conn = $args[0];
                break;
            case 4:
                $this->conn = $args[0];
                $this->client_id = $args[1];
                $this->date = date("Y-m-d");
                $this->type_id = $args[2];
                $this->value = $args[3];
                break;
        }
    }

    function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
        return false;
    }

    function getLastByClientId()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CLIENT_ID = :id ORDER BY DATE DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $_SESSION['id']);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row['DATE'];
        }
        return false;
    }

    function create()
    {
        $query = "INSERT INTO " . $this->table_name . " VALUES (NULL, :client_id, :date, :type_id, :value)";

        $stmt = $this->conn->prepare($query);
        $this->value = htmlspecialchars(strip_tags($this->value));

        $stmt->bindParam(':client_id', $this->client_id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':type_id', $this->type_id);
        $stmt->bindParam(':value', $this->value);

        $stmt->execute();
    }

    function update($client_id, $type_id, $value)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CLIENT_ID = :client_id AND 
        TYPE_ID = :type_id ORDER BY DATE DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':type_id', $type_id);
        $stmt->execute();
        $row = $stmt->fetch();
        $query = "UPDATE " . $this->table_name . " SET VALUE = :value WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $row['ID']);
        $stmt->bindParam(':value', $value);
        $stmt->execute();
    }
}