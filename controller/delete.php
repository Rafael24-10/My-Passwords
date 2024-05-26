<?php
include("../controller/database/db_connection.php");
include("./actions.php");
session_start();
$id = $_SESSION["user_id"];
$delete = new Actions;

$delete -> destroy($id, $conn);
?>