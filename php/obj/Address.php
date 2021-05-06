<?php

class Address
{
    public $street, $house, $apartment;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'address';
        $args = func_get_args();
        $cnt = func_num_args();
        switch ($cnt) {
            case 1:
                $this->conn = $args[0];
                break;
            case 4:
                $this->conn = $args[0];
                $this->street = $args[1];
                $this->house = $args[2];
                $this->apartment = $args[3];
                break;
        }
    }

    function checkIfExist()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE STREET = :street AND 
        HOUSE = :house AND APARTMENT = :apartment";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house', $this->house);
        $stmt->bindParam(':apartment', $this->apartment);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['ID'] != null;
    }

    function getId()
    {
        $query = "SELECT * FROM " . $this->table_name . " 
            WHERE STREET = :street AND HOUSE = :house AND APARTMENT = :apartment LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house', $this->house);
        $stmt->bindParam(':apartment', $this->apartment);

        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row['ID'];
        }

        return null;
    }

    function getById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            $this->street = $row['STREET'];
            $this->house = $row['HOUSE'];
            $this->apartment = $row['APARTMENT'];
        }
    }

    function getAll()
    {
        $query = "SELECT DISTINCT STREET FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }

        return false;
    }

    function getByStreet($street)
    {
        $query = "SELECT DISTINCT HOUSE FROM " . $this->table_name . " WHERE STREET = :street";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':street', $street);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }

        return false;
    }

    function getMaxApartment()
    {
        $query = "SELECT MAX(APARTMENT) FROM " . $this->table_name . " WHERE STREET = :street AND HOUSE = :house";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house', $this->house);
        if ($stmt->execute()) {
            return $stmt->fetch()[0];
        }

        return false;
    }

}