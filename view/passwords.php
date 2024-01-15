<?php
include("../controller/actions.php");
include("../controller/database/db_connection.php");
include("../controller/Password_hashing.php");
$actions = new Actions();
$hashing = new Hashing();
$id = $actions->isAuth();
$passwords = $actions->showPass($id, $conn);
$master = $actions->show($id, $conn);
$master_password = $master["master_password"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password_name = $_POST["password_name"];
    $password_value = $_POST["password_value"];
    $hashed = $hashing->encrypting($password_value, $master_password);
    $hashing->passInsert($password_name, $hashed, $id, $conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/passwords.css">
    <title>Passwords</title>
</head>

<body>
    <div class="top-page">

        <div class="user-info">
            <img src="../public/images/user.svg" alt="">
            <h3><?php echo $master["username"] ?></h3>
            <button id="icon-btn" class="icon-btn" type="button" onclick="toggleDropdown()">
                <img class="drop-icon" id="drop-icon" src="../public/images/caret-down-outline.svg">
            </button>
            <div class="dropdown-content" id="dropdown">
                <a href="edit.php">Profile</a>
                <a href="../controller/logout.php">Logout</a>
            </div>
        </div>
        <h1>My passwords</h1>
    </div>

    <dialog id="add-dialog" class="add-dialog">
        <form autocomplete="off" id="form" action="" method="POST" onsubmit="return validateForm()">
            <input type="text" class="text-input" maxlength="20" name="password_name" placeholder="Title" required>
            <input type="password" class="password-input" id="password-input" name="password_value" maxlength="35" placeholder="Password" required>
            <div id="error-message" class="error-message"></div>
            <button class="add-btn" type="submit">Add Password</button>
            <button type="reset" class="cancel-btn" id="cancel-btn">Cancel</button>
        </form>

    </dialog>
    
        <button id="add-button" class="add-password">
            <img class="add" src="../public/images/add.svg" alt="">
            <h3>Add password</h3>
        </button>



    <!-- <a href="./homepage.php">Home</a> -->


    <div class="container">
        <!-- <hr> -->
        <?php
        if ($passwords == null) {
            echo "<div class='message'>";
            echo "<h2>No passwords saved yet!</h2>";
            echo "</div>";
        } else {
            foreach ($passwords as $index => $password) {
        ?>
                <dialog class="dialog" id="dialog<?= $index ?>">

                    <div class="password-box">
                        <div class='password-info'>
                            <?php echo  "Name: " . $password["password_name"] . "<br>"; ?>
                            <?php echo "Password: " . $hashing->decrypting($password["password_value"], $master_password) . "<br>"; ?>
                        </div>
                        <div class='password-actions'>
                            <?php
                            echo "<a href='#' onclick='confirmDelete(\"" . urlencode($password["password_name"]) . "\")'>Delete   </a>";
                            echo "<a href='./password_edit.php?name=" . urlencode($password["password_name"]) . "'>Edit</a>";
                            ?>

                        </div>
                        <button autofocus>Close</button>
                    </div>
                </dialog>
                <!-- <button class="show-password-button" data-dialog="dialog<?= $index ?>">PASSWORD</button> -->
                <div class="password">
                    <div class="label-box">
                        <span><?php echo $password["password_name"] ?></span>
                    </div>
                    <div class="image-box">
                        <img class="show-password-trigger" src="../public/images/chave.svg" alt="Show Password" data-dialog="dialog<?= $index ?>">
                    </div>
                </div>
        <?php
            }
        }
        ?>

    </div>

    <script src="../public/js/script.js"></script>
    <script src="../public/js/dialog.js"></script>
    <script src="../public/js/dropdown.js"></script>
    <script src="../public/js/validate_form.js"></script>


</body>

</html>