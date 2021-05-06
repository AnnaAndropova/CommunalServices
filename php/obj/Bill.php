<?php
require 'vendor/autoload.php';

class Bill
{
    private $conn, $table_name;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->table_name = 'bill';
    }

    function getById($id)
    {
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

    function getAllByClientId()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CLIENT_ID = :id ORDER BY DATE DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $_SESSION['id']);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return false;
    }

    function getAllFromId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CLIENT_ID = :client_id AND ID <= :id ORDER BY DATE DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':client_id', $_SESSION['id']);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return false;
    }

}