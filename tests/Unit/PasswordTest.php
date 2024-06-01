<?php

namespace Tests\Unit;

use App\Models\Password;
use PHPUnit\Framework\TestCase;


require_once __DIR__ . '/../../vendor/autoload.php';

class PasswordTest extends TestCase
{
    private $password;

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
        $this->password = new Password();
    }

    private function callProtectedMethod($object, $methodName, array $args = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function testCreatePassword()
    {
        $data = [
            'password_name' => 'testpassname',
            'password_value' => '123456789',
            'user_id' => 1
        ];

        $result = $this->callProtectedMethod($this->password, 'createPassword', [$data]);
        $this->assertEquals(0, $result);
    }

    public function testFetchPasswordsFromUser()
    {
        $userId = 1;

        $result = $this->callProtectedMethod($this->password, 'fetchPasswordsFromUser', [$userId]);
        $this->assertIsArray($result);
    }

    public function testUpdatepassword()
    {
        $passwordId = 1;
        $data = [
            'password_name' => 'updatedPassName',
            'password_value' => '135790',
        ];

        $result = $this->callProtectedMethod($this->password, 'updatePassword', [$passwordId, $data]);
        $this->assertEquals(0, $result);
    }

    public function testDestroyPassword()
    {
        $passwordId = 1;

        $result = $this->callProtectedMethod($this->password, 'destroyPassword', [$passwordId]);
        $this->assertEquals(0, $result);
    }
}
