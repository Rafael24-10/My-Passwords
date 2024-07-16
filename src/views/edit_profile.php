<?php

use App\Controllers\UserController;

require_once __DIR__ . '/../../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$UserController = new UserController();
$user = $UserController->userGet($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email']
    ];

    $UserController->userUpdate($_SESSION['user_id'], $data);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/edit.css">
    <title>Edit</title>
</head>

<body>

    <div class="top-page">

        <div class="user-info">
            <img src="../public/images/user.svg" alt="">
            <h3><?php echo $user["username"] ?></h3>
            <button id="icon-btn" class="icon-btn" type="button" onclick="toggleDropdown()">
                <img class="drop-icon" id="drop-icon" src="../public/images/caret-down-outline.svg">
            </button>
            <div class="dropdown-content" id="dropdown">
                <a href="dashboard.php">Passwords</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <h1>My passwords</h1>
    </div>

    <style>
        section{
background-color: white;
        }

        .top-page {
            background-color: #333873;

        }
    </style>



    <section>
        <div class="login-box">
            <div class="user-img">
                <img src="../public/images/user.svg">
            </div>

            <form autocomplete="off" action="" method="POST">

                <div class="input-box">
                    <input type="text" name="username" maxlength="15" value="<?php echo $user["username"] ?>" required>
                    <input type="text" name="email" value="<?php echo $user["email"] ?>" required>
                </div>

                <div class="actions">
                    <button id="submit-btn" type="submit" onclick="return confirm('Are you sure you want to save the changes?')" )>SAVE</button>
                    <div class="delete">
                        <a href="delete_profile.php" onclick="return confirm('Are you sure you want to delete your account?')" ;>
                            <img src="../public/images/trash.svg">
                        </a>
                        <a href="delete_profile.php" onclick="return confirm('Are you sure you want to delete your account?')" ;>Delete account</a>
                    </div>
                </div>
            </form>
        </div>
    </section>


    <script src="../public/js/dropdown.js"></script>


</body>

</html>