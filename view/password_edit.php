<?php
include("../controller/database/db_connection.php");
include("../controller/Password_hashing.php");
include("../controller/actions.php");

$actions = new Actions;
$hashing = new Hashing;
$id = $actions->isAuth();
$name = $_GET['name'];
$passwords = $actions->selectPass($name, $conn);
$password = $passwords["password_value"];
$master = $actions->show($id, $conn);
$master_password = $master["master_password"];
$decrypted = $hashing->decrypting($password, $master_password);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password_name = $_POST["password_name"];
    $password_value = $_POST["password_value"];
    $hashed = $hashing->encrypting($password_value, $master_password);

    $newdata = [
        'password_name' => $password_name,
        'password_value' => $hashed
    ];

    $update = new Hashing;
    $update->passUpdate($name, $conn, $newdata);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/password_edit.css">
    <title>Password edit</title>
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
                <a href="./passwords.php">Passwords</a>
            </div>
        </div>
        <h1>My passwords</h1>
    </div>


    <section>
        <div class="form">
            <form autocomplete="off" action="" method="POST">
                <div class="input-box">
                    <input type="text" name="password_name" value="<?php echo $passwords["password_name"] ?>" required>
                    <input type="text" name="password_value" value="<?php echo  $decrypted ?>" required>
                </div>
                <div class="actions">
                    <button type="submit">Save</button>
                    <a href="./passwords.php">Cancel</a>
                </div>
            </form>
        </div>
    </section>
    <script src="../public/js/dropdown.js"></script>
</body>

</html>