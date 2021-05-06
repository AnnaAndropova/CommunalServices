<?php
require 'vendor/autoload.php';

class Price
{
    public $type_id, $value, $price;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'price';
        $args = func_get_args();
        $cnt = func_num_args();
        switch ($cnt) {
            case 1:
                $this->conn = $args[0];
                break;
            case 4:
                $this->conn = $args[0];
                $this->type_id = $args[1];
                $this->value = $args[2];
                $this->price = $args[3];
                break;
        }
    }

    function getByTypeId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE TYPE_ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
        return false;
    }

    function getAll()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return false;
    }

    function update()
    {
        $query = "UPDATE " . $this->table_name . " SET VALUE = :value, PRICE = :price WHERE ID = :id";

        $stmt = $this->conn->prepare($query);
        $this->value = htmlspecialchars(strip_tags($this->value));
        $this->price = htmlspecialchars(strip_tags($this->price));

        $stmt->bindParam(':id', $this->type_id);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':value', $this->value);

        $stmt->execute();
    }

    /*
    function getLast()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY DATE DESC LIMIT 1"; // Добавить дату в цены
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row['DATE'];
        }
        return false;
    }
    */

}