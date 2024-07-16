<?php

use App\Controllers\PasswordController;
use App\Controllers\UserController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
$user = new UserController();
$PasswordController = new PasswordController();
$user->isAuth($_SESSION["user_id"]);
$userGet = $user->userGet($_SESSION['user_id']);
$userKey = $userGet['master_password'];
$pass = $PasswordController->userPasswords($_SESSION['user_id']);

if ($pass != null) {
    $passwords = $user->decryptPasswords($pass, $userKey);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../public/css/passwords.css"> -->
    <title>My Passwords</title>
</head>

<body>
    <div class="top-page">

        <div class="user-info">
            <img src="../public/images/user.svg" alt="">
            <h3><?php echo $userGet["username"] ?></h3>
            <button id="icon-btn" class="icon-btn" type="button" onclick="toggleDropdown()">
                <img class="drop-icon" id="drop-icon" src="../public/images/caret-down-outline.svg">
            </button>
            <div class="dropdown-content" id="dropdown">
                <a href="edit_profile.php">Profile</a>
                <a href="./logout.php">Logout</a>
            </div>
        </div>
        <h1>My passwords</h1>
    </div>

    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <button type="button" class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add New Password</button>
                <div class="card">
                    <div class="card-body text-center d-flex mx-2 my-4">

                        <?php if ($pass == null) { ?>
                            <h3>No passwords saved yet :(</h3>
                        <?php } else { ?>

                            <div class="row">
                                <!-- foreach here  -->
                                <?php foreach ($passwords as $password) { ?>
                                    <?php if (count($passwords) < 3) {
                                        echo "<div class='col-md-6 mb-3'>";
                                    } else {
                                        echo "<div class ='col-md-4 mb-3'>";
                                    } ?>
                                    <!-- <div class="col-md-5 mb-3"> -->
                                    <div class="card mx-2" style="width: 12rem;">
                                        <img src="../public/images/chave.svg" class="card-img-top" alt="key image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $password['password_name'] ?></h5>
                                            <p class="card-text"><?php echo $password['password_value'] ?></p>
                                            <div class="dropdown">
                                                <button class="btn btn-info dropdown-toggle mx-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Options
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $password['password_id'] ?>" href="">Edit</a></li>
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#confirmationModal<?php echo $password['password_id'] ?>" href="">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- edit modal  -->
                                    <div class="modal" id="editModal<?php echo $password['password_id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit password</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="./edit.php" method="POST">
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Password name:</label>
                                                            <input type="text" class="form-control" name="new_password_name" id="recipient-name" value="<?php echo $password['password_name'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text" class="col-form-label">Password:</label>
                                                            <textarea class="form-control" name="new_password_value" id="message-text"><?php echo $password['password_value'] ?></textarea>
                                                            <input type="hidden" name="password_id" value="<?php echo $password['password_id'] ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete modal  -->
                                    <div class="modal" id="confirmationModal<?php echo $password['password_id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to delete this password?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="deleteForm" action="./delete.php" method="POST">
                                                        <input type="hidden" name="password_to_delete" value="<?php echo $password['password_id'] ?>">
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end delete modal -->
                                    <!-- end edit modal  -->
                                    <!-- end foreach -->
                            </div>
                        <?php } ?>
                    </div>
                <?php  } ?>

                <!-- Add password Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">New Password</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="./create.php" method="POST">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Password name:</label>
                                        <input type="text" class="form-control" name="password_name" id="recipient-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="message-text" class="col-form-label">Password:</label>
                                        <textarea class="form-control" name="password_value" id="message-text"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end add password modal=- -->


                </div>
            </div>
        </div>
    </div>
    </div>





    <style>
        .dropdown-item:hover {
            background-color: #6c757d;
            color: #fff;
        }

        .action-link {
            text-decoration: none;
            color: #fff;
        }

        .top-page {
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* background-color: #4C5982; */
            background-color: #333873;
            height: 80px;
        }

        .top-page h1 {
            width: 280px;

        }

        .user-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-left: 10px;
        }

        .user-info h3 {
            padding-left: 10px;
        }

        .drop-icon {
            width: 20px;
            height: 20px;
            margin-top: 3px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 50px;
            left: 150px;
            border-radius: 3px;
            background-color: #333;
            box-shadow: 3px 3px 10px black;
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .icon-btn {
            border: none;
            background-color: transparent;
        }

        .dropdown-content a:hover {
            background-color: #555;
        }
    </style>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../public/js/dropdown.js"></script>

</body>

</html>