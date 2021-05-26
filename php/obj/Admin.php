<?php


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
        if (isset($_POST['reg'])) {
            if (empty($_POST['login']) || empty($_POST['password'])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else {
                $query = "INSERT INTO " . $this->table_name . " VALUES 
                    (NULL, 
                    :login, 
                    :password)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':login', $_POST['login']);
                $stmt->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
                if ($stmt->execute()) {

                    header("Location: ../index.php");
                    exit();

                }
            }
        }
    }


    function checkLogin()
    {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE LOGIN = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $this->login);
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $rows[0] != 0;
        }
        return false;
    }

    function login()
    {
        if (isset($_POST['do_login'])) {
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

                        header("Location: adminfirstpage.php");
                        exit();

                    } else {
                        return [
                            'message' => "Неверный логин или пароль"
                        ];
                    }
                } else {
                    return [
                        'message' => "Неверный логин или пароль"
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
        session_unset();
        header("Location: authorization.php");
    }

}