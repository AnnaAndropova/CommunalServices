<?php


class Client
{
    public $address_id, $tenant_count, $surname, $name, $patronymic, $login, $password;
    private $conn, $table_name;

    public function __construct()
    {
        $this->table_name = 'client';
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
            case 8:
                $this->conn = $args[0];
                $this->address_id = $args[1];
                $this->tenant_count = $args[2];
                $this->surname = $args[3];
                $this->name = $args[4];
                $this->patronymic = $args[5];
                $this->login = $args[6];
                $this->password = $args[7];
                break;
        }
    }

    function create()
    {
        if (isset($_POST['reg'])) {
            if (empty($_POST['street']) || empty($_POST['house']) || empty($_POST['apartment']) ||
                empty($_POST['surname']) || empty($_POST['name']) || empty($_POST['patronymic']) ||
                empty($_POST['tenant_count']) || empty($_POST['login']) || empty($_POST['password'])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else {
                $address = new Address($this->conn, $_POST['street'], $_POST['house'], $_POST['apartment']);
                if ($address->checkIfExist()) {
                    $this->tenant_count = $_POST['tenant_count'];
                    $this->surname = htmlspecialchars($_POST['surname']);
                    $this->name = htmlspecialchars($_POST['name']);
                    $this->patronymic = htmlspecialchars($_POST['patronymic']);
                    $this->login = htmlspecialchars($_POST['login']);
                    $this->password = htmlspecialchars($_POST['password']);
                    if ($this->checkLogin()) {
                        return [
                            'message' => "Данный логин уже существует"
                        ];
                    }
                    if ($this->tenant_count < 0) {
                        return [
                            'message' => "Недопустимое значение количества жильцов"
                        ];
                    }
                    $addressId = $address->getId();
                    $query = "INSERT INTO " . $this->table_name . " VALUES 
                    (NULL, 
                    :address, 
                    :count, 
                    :surname, 
                    :name, 
                    :patronymic,
                    :login, 
                    :password)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':address', $addressId);
                    $stmt->bindParam(':login', $this->login);
                    $stmt->bindParam(':count', $this->tenant_count);
                    $stmt->bindParam(':surname', $this->surname);
                    $stmt->bindParam(':name', $this->surname);
                    $stmt->bindParam(':patronymic', $this->patronymic);
                    $stmt->bindParam(':password', password_hash($this->password, PASSWORD_DEFAULT));
                    if ($stmt->execute()) {

                        header("Location: ../index.php");
                        return [];

                    }
                } else {
                    return [
                        'message' => "Неверный адрес"
                    ];
                }
            }
        }
    }

    // ЭТО РАБОТАЕТ НО НЕ РАБОТАЛО ????
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

    function checkAddress()
    {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE ADDRESS_ID = :address_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':address_id', $this->address_id);
        if ($stmt->execute()) {
            $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
            return $rows[0] != 0;
        }
        return false;
    }

    function changeData()
    {
        if (isset($_POST['change'])) {
            if (empty($_POST['street']) || empty($_POST['house']) || empty($_POST['apartment']) ||
                empty($_POST['tenant_count']) || empty($_POST['login'])) {

                    $message = "Заполните все поля";
                return [
                    'message' => $message
                ];
            } else {
                $address = new Address($this->conn, $_POST['street'], $_POST['house'], $_POST['apartment']);

                if ($address->checkIfExist()) {
                    $this->tenant_count = $_POST['tenant_count'];
                    $this->login = $_POST['login'];

                    if ($this->tenant_count < 0) {
                            $message = "Недопустимое значение количества жильцов";
                        return [
                            'message' => $message
                        ];
                    }
                    $addressId = $address->getId();
                    if ($addressId != null) {
                        $query = "UPDATE " . $this->table_name . " 
            SET ADDRESS_ID = :address, TENANT_COUNT = :count WHERE ID = :id";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bindParam(':address', $addressId);
                        $stmt->bindParam(':count', $this->tenant_count);
                        $stmt->bindParam(':id', $_SESSION['id']);
                        if ($stmt->execute()) {
                            header("Location: account.php");
                            return [];
                        }
                    } else {

                            $message = "Неверный адрес";
                        return [
                            'message' => $message
                        ];
                    }
                } else {

                    $message = "Неверный адрес";
                    return [
                        'message' => $message
                    ];
                }
            }
        }
        return [];
    }

    function getById()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $_SESSION['id']);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }

        return false;
    }

    function getById1($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }

        return false;
    }

    function login($arr)
    {
        $message = null;
        if (isset($arr['do_login'])) {
            if (empty($arr['login']) || empty($arr['password'])) {

                $message = "Заполните все поля";

            } else {
                $this->login = $arr['login'];
                $this->password = $arr['password'];
                if ($this->checkLogin()) {
                    if ($this->checkPassword()) {
                        $_SESSION['id'] = $this->getId();
                        $_SESSION['isAdmin'] = false;


                        header("Location: account.php");
                        exit();


                    } else {

                        $message = "Неверный логин или пароль";

                    }
                } else {

                    $message = "Неверный логин или пароль";

                }
            }
        }
        return [
            'message' => $message
        ];
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

    function getId()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE LOGIN = :login LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $this->login);

        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row['ID'];
        }

        return null;
    }

    function changePassword()
    {
        if (isset($_POST['password'])) {
            $query = "SELECT * FROM " . $this->table_name . " WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $_SESSION['id']);

            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $this->login = $row['LOGIN'];
            }
            $this->password = $_POST['old_password'];
            if (empty($_POST['old_password']) || empty($_POST['new_password']) || empty($_POST['repeat_password'])) {
                return [
                    'message' => "Заполните все поля"
                ];
            } else if (!$this->checkPassword()) {
                return [
                    'message' => "Неверный текущий пароль"
                ];
            } else if (strcmp($_POST['new_password'], $_POST['repeat_password']) != 0) {
                return [
                    'message' => "Пароли не совпадают"
                ];
            }
            $query = "UPDATE " . $this->table_name . " SET PASS = :password WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', password_hash($_POST['new_password'], PASSWORD_DEFAULT));
            $stmt->bindParam(':id', $_SESSION['id']);

            $stmt->execute();
        }
    }

    function logout()
    {
        session_unset();
        header("Location: authorization.php");
    }

}