<?php
include("./database/db_connection.php");
include("./Password_hashing.php");
include("./actions.php");


$id = urldecode($_GET['name']);
$delete = new Hashing;
$delete -> passDestroy($id, $conn);

?>