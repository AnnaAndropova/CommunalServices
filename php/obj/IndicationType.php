<?php


class IndicationType
{
    public $name, $units;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'indication_type';
        $args = func_get_args();
        $cnt = func_num_args();
        switch ($cnt) {
            case 1:
                $this->conn = $args[0];
                break;
            case 3:
                $this->conn = $args[0];
                $this->name = $args[1];
                $this->units = $args[2];
                break;
        }
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

    function getAll(){
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return false;
    }


}