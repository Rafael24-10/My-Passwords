<?php

namespace Tests\Unit;

use App\Controllers\PasswordController;
use PHPUnit\Framework\TestCase;


require_once __DIR__ . '/../../vendor/autoload.php';

class PasswordControllerTest extends TestCase
{
    private PasswordController $controller;

    protected function setUp(): void
    {
        $servername = "localhost";
        $username = "admin";
        $password = "93072394";
        $dbname = "password_manager";

        $conn = new \mysqli($servername, $username, $password, $dbname);

        $sqlDeleteUsers = "DELETE FROM users";
        $sqlDeletePasswords = "DELETE FROM passwords";
        $sqlResetUsers = "ALTER TABLE users AUTO_INCREMENT = 1";
        $sqlResetPasswords = "ALTER TABLE passwords AUTO_INCREMENT = 1";

        $conn->query($sqlDeleteUsers);
        $conn->query($sqlDeletePasswords);
        $conn->query($sqlResetUsers);
        $conn->query($sqlResetPasswords);

        $sqlInsertUser = "INSERT INTO users (username, master_password, email) VALUES ('testUser', 'hashed_password', 'test@example.com')";
        $conn->query($sqlInsertUser);
        $this->controller = new PasswordController();
    }

    public function testPasswordCreate()
    {
        $data = [
            'password_name' => 'testpassname',
            'password_value' => '123456789',
            'user_id' => 1
        ];
        $result = $this->controller->passwordCreate($data);
        $this->assertEquals(0, $result);
    }

    public function testUserPasswords()
    {
        $result = $this->controller->userPasswords(1);
        $this->assertIsArray($result);
    }

    public function testPasswordUpdate()
    {
        $data = [
            'password_name' => 'updatedPassName',
            'password_value' => '135790',
        ];
        $result = $this->controller->passwordUpdate(1, $data);
        $this->assertEquals(0, $result);
    }

    public function testPasswordDelete()
    {
        $result = $this->controller->passwordDelete(1);
        $this->assertEquals(0, $result);
    }
}
