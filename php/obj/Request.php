<?php
require 'vendor/autoload.php';

class Request
{
    public $client_id, $indication_type_id, $value, $date;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'request';
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
                $this->indication_type_id = $args[2];
                $this->value = $args[3];
                break;
        }
    }

    function getLastByClientId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE CLIENT_ID = :id ORDER BY DATE DESC LIMIT 2";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll();
            return $rows[1];
        }
        return false;
    }

    function create()
    {
        if (isset($_POST['SOME_ARR'])) {
            if (empty($_POST['value'])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else if ($_POST['value'] < 0) {
                return [
                    'message' => "Недопустимое значение показания"
                ];
            }
            $this->client_id = $_SESSION['id'];
            $this->indication_type_id = $_POST['indication'];
            $this->value = $_POST['value'];
            $this->date = date("Y-m-d");
            $query = "INSERT INTO " . $this->table_name . " VALUES (NULL, :client_id, :indication_type_id, :value, :date)";

            $stmt = $this->conn->prepare($query);
            $this->value = htmlspecialchars(strip_tags($this->value));

            $stmt->bindParam(':client_id', $this->client_id);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':indication_type_id', $this->indication_type_id);
            $stmt->bindParam(':value', $this->value);

            $stmt->execute();
        }
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

    function getById()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";

        $stmt = $this->conn->prepare($query);
        $this->value = htmlspecialchars(strip_tags($this->value));

        $stmt->bindParam(':id', $_GET['id']); // передавать ид в ссылку и оттуда получать

        $stmt->execute();
        return $stmt->fetch();
    }

    function accept()
    {
        if (isset($_POST['SOME_ARR'])) {
            $query = "UPDATE " . $this->table_name . " SET IS_CHECKED = TRUE WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $row = $stmt->fetch();
            $this->client_id = $row['CLIENT_ID'];
            $this->indication_type_id = $row['INDICATION_TYPE_ID'];
            $this->value = $row['VALUE'];
            $ind = new Indication($this->conn);
            $ind->update($this->client_id, $this->indication_type_id, $this->value);
        }
    }

    function deny(){
        if (isset($_POST['SOME_ARR'])) {
            $query = "UPDATE " . $this->table_name . " SET IS_CHECKED = TRUE WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $_GET['id']); // передавать ид в ссылку и оттуда получать
            $stmt->execute();
        }
    }
}
