<?php
include 'main_header.php';

require '../php/obj/Database.php';
require '../php/obj/Client.php';
require '../php/obj/Admin.php';
$db = new Database();
$conn = $db->getConnection();
$client = new Client($conn);
$adm = new Admin($conn);
if (isset($_SESSION['id'])) {
    $client->logout();
} else if (isset($_SESSION['isAdmin'])) {
    $adm->logout();
}
$arrAdm = $adm->login();
if (!empty($arrAdm['message'])) {
    $arr = $client->login($_POST);
}

?>

<main class="main">
    <section class="bills">
        <div class="container">

            <h1>ВХОД</h1>
            <hr>


            <form method="post">

                <label for="login"><b>ЛОГИН</b></label>
                <input type="text" name='login' required>

                <label for="password"><b>ПАРОЛЬ</b></label>
                <input type="password" name='password' required>


                <div class="error">
                    <?php
                    if (!empty($arr['message'])) {
                        echo $arr['message'];
                    }
                    ?>
                </div>

                <hr>


                <input type="submit" class="registerbtn" name='do_login' value="ВОЙТИ">
            </form>
            <form action="registration.php">
                <input type="submit" class="registerbtn" name="REGISTRATION" value="ЗАРЕГИСТРИРОВАТЬСЯ">
            </form>


        </div>
    </section>
</main>

</body>

</html>