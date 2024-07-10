<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

use App\Controllers\PasswordController;

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
$password_name = $_POST['password_name'];
$password_value = $_POST['password_value'];
$userId = $_SESSION['user_id'];
$data = [
    'password_name' => $password_name,
    'password_value' => $password_value,
    'user_id' => $userId
];

$passwordController = new PasswordController();
$passwordController->passwordCreate($data);
