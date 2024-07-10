<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Controllers\PasswordController;
session_start();
require_once __DIR__ . '/../../vendor/autoload.php';


$passwordController = new PasswordController();

$id = $_POST['password_id'];
$password_name = $_POST['new_password_name'];
$password_value = $_POST['new_password_value'];

$data = [
    'password_name' => $password_name,
    'password_value' => $password_value
];

$passwordController->passwordUpdate($id, $data);
