<?php

use App\Controllers\UserController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = [
        'username' => htmlspecialchars($username = $_POST['username']),
        'master_password' => $password = $_POST['password'],
    ];

    $userController = new UserController();
    $userController->userLogin($data);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>login</title>
</head>

<body>
    <section>
        <div class="login-box">


            <form autocomplete="off" action="" method="POST">
                <h2>Login</h2>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>


                <button type="submit">Login</button>

                <div class="register-link">
                    <p>Don't have an account?<a href="./register.php"> Register</a></p>
                </div>
                <h3><a href="../">My Passwords</a></h3>

            </form>

        </div>
    </section>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>