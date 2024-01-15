<?php
include("../controller/database/db_connection.php");
include("../controller/Password_hashing.php");
include("../controller/actions.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $actions = new Actions;
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    //instatiates the hashing class and hashes the password
    $hashing = new Hashing;
    $hashed_password = $hashing->bcrypt($password);

    $data = [
        'username' => $username,
        'master_password' => $hashed_password,
        'email' => $email
    ];

    //instantiates the Actions class and registers a new user

    $actions->Register($data, $conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Register</title>
</head>

<body>
    <section>
        <div class="login-box">


            <form autocomplete="off" action="" method="POST">
                <h2>Register</h2>
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>

                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>


                <button type="submit">Create Account</button>

                <h3><a href="../">My Passwords</a></h3>




            </form>

        </div>
    </section>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

<style>
    h3 {
        margin-top: 20px;
    }
</style>

</html>