<?php
session_start();
session_destroy();
header("LOCATION: ../view/index.php");
exit();
?>