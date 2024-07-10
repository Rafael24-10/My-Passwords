<?php

use App\Controllers\PasswordController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

$id = $_POST['password_to_delete'];

$passwordController = new PasswordController();
$passwordController->passwordDelete($id);
