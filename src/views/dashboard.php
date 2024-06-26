<?php

 use App\Controllers\UserController;

 require_once __DIR__ . '/../../vendor/autoload.php';
 $user = new UserController();
// $user->isAuth($_SESSION["user_id"]);
 $users = $user->allUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../output.css" rel="stylesheet">
    <title>My Passwords</title>
</head>

<body>
    <?php foreach ($users as $user) { ?>
        <ul>
            <li class="font-black"><?php echo $user["username"] ?></li>
        </ul>
    <?php } ?>



</body>

</html>