<?php
require 'vendor/autoload.php';

class Admin
{
    public $login, $password;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'admin';
        $args = func_get_args();
        $cnt = func_num_args();
        switch ($cnt) {
            case 1:
                $this->conn = $args[0];
                break;
            case 3:
                $this->conn = $args[0];
                $this->login = $args[1];
                $this->password = $args[2];
                break;
        }
    }

    function create()
    {
        if (isset($_POST['SOME_NAME'])) {
            if (empty($_POST['login']) || empty($_POST['password'])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else if (empty($_POST['street']) && empty($_POST['house']) && empty($_POST['apartment']) &&
                empty($_POST['surname']) && empty($_POST['name']) && empty($_POST['patronymic']) &&
                empty($_POST['tenant_count']) && !empty($_POST['login']) && !empty($_POST['password'])) {
                if ($this->checkLogin()) {
                    return [
                        'message' => "Данный логин уже существует"
                    ];
                }
                $query = "INSERT INTO " . $this->table_name . " VALUES 
                    (NULL, 
                    LOGIN = :login, 
                    PASS = :password)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':login', $this->login);
                $stmt->bindParam(':password', password_hash($this->password, PASSWORD_DEFAULT));
                if ($stmt->execute()) {

                    //header("Location: /index.php");
                    exit();

                }
            }
        }
    }

    function checkLogin()
    {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE LOGIN = :login";
        $res = $this->conn->query($query);
        $row = $res->fetchAll(PDO::FETCH_COLUMN);
        return $row[0] != null;
    }

    function login()
    {
        if (isset($_POST["SOME_NAME"])) {
            if (empty($_POST['login']) || empty($_POST['password'])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else {
                $this->login = $_POST['login'];
                $this->password = $_POST['password'];
                if ($this->checkLogin()) {
                    if ($this->checkPassword()) {
                        $_SESSION['isAdmin'] = true;

                        //header("Location: /index.php");
                        exit();

                    } else {
                        return [
                            'message' => "Неверный пароль"
                        ];
                    }
                } else {
                    return [
                        'message' => "Неверный логин"
                    ];
                }
            }
        }
    }

    function checkPassword()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE LOGIN = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $this->login);

        $stmt->execute();
        $row = $stmt->fetch();

        $hash = $row['PASS'];
        return password_verify($this->password, $hash);
    }

    function logout(){

    }

}