<?php

namespace Tests\Unit;

use App\Controllers\UserController;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserControllerTest extends TestCase
{
    private UserController $controller;

    protected function setUp(): void
    {
        $servername = "localhost";
        $username = "admin";
        $password = "93072394";
        $dbname = "password_manager";

        $conn = new \mysqli($servername, $username, $password, $dbname);
        $options = [
            'cost' => 12
        ];
        $password = password_hash("123456789", PASSWORD_BCRYPT, $options);

        $sqlDelete = "DELETE FROM users";
        $sqlReset = "ALTER TABLE users AUTO_INCREMENT = 1";
        $sqlInsert = "INSERT INTO users (username, master_password, email) VALUES ('testUser2', '$password', 'email@email.com')";
        $conn->query($sqlDelete);
        $conn->query($sqlReset);
        $conn->query($sqlInsert);
        $conn->close();

        $this->controller = new UserController();
    }

    public function testUserCreate()
    {
        $data = [
            "username" => "testUser3",
            "email" => "email2@email.com",
            "master_password" => "123456789"
        ];

        $result = $this->controller->userCreate($data);
        $this->assertEquals(0, $result);
    }

    public function testAllUsers()
    {
        $result = $this->controller->allUsers();
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        $this->assertEquals('testUser2', $result[0]["username"]);
    }

    public function testUserGet()
    {
        $result = $this->controller->userGet(1);
        $this->assertIsArray($result);
        $this->assertNotNull($result);
    }

    public function testUserLogin()
    {
        $data = [
            "username" => "testUser2",
            "email" => "email2@email.com",
            "master_password" => "123456789"
        ];
        $result = $this->controller->userLogin($data);
        $this->assertEquals(0, $result);
    }

    public function testUserUpdate()
    {
        $id = 1;
        $data = [
            "username" => "novoUser",
            "email" => "email2@email.com"
        ];

        $result = $this->controller->userUpdate($id, $data);
        $this->assertEquals(0, $result);
    }

    public function testeUserDelete()
    {
        $result = $this->controller->userDelete(1);
        $this->assertEquals(0, $result);
    }
}
