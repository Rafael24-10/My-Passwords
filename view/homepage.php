<?php
include("../controller/database/db_connection.php");
include("../controller/actions.php");

$actions = new Actions();
$id = $actions::isAuth();
$userdata = $actions->show($id, $conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>

<body>
    <h1>This is the homepage</h1>
    <p>Welcome <?php echo $userdata["username"] ? $userdata["username"] : "Username"?></p>

    <a href="../controller/logout.php">Logout</a>
    <a href="./edit.php">Edit profile</a>
    <a href="./passwords.php">My Passwords</a>
</body>

</html>