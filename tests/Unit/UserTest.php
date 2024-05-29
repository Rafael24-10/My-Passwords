<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/autoload.php';

class UserTest extends TestCase
{
    private $user;

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

        $this->user = new User();
    }

    private function callProtectedMethod($object, $methodName, array $args = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function testCreateUser()
    {
        $data = [
            "username" => "testUser3",
            "email" => "email2@email.com",
            "master_password" => "123456789"
        ];
        $result = $this->callProtectedMethod($this->user, 'createUser', [$data]);
        $this->assertEquals(0, $result);
    }

    public function testAll()
    {
        $result = $this->callProtectedMethod($this->user, 'all');
        $this->assertIsArray($result);
        $this->assertNotNull($result);
        $this->assertEquals('testUser2', $result[0]["username"]);
    }

    public function testFetchUser()
    {
        $data = 1;
        $result = $this->callProtectedMethod($this->user, 'fetchUser', [$data]);
        $this->assertIsArray($result);
        $this->assertNotNull($result);
    }

    public function testLogin()
    {
        $data = [
            "username" => "testUser2",
            "email" => "email@email.com",
            "master_password" => "123456789"
        ];


        $result = $this->callProtectedMethod($this->user, 'login', [$data]);
        $this->assertEquals(0, $result);
    }

    public function testUpdateUser()
    {
        $id = 1;
        $data = [
            "username" => "novoUser",
        ];

        $result = $this->callProtectedMethod($this->user, 'updateUser', [$id, $data]);

        $this->assertEquals(0, $result);
    }

    public function testDestroyUser()
    {
        $id = 1;
        $result = $this->callProtectedMethod($this->user, 'destroyUser', [$id]);
        $this->assertEquals(0, $result);
    }
}
