<?php

namespace Tests\Unit;

use App\Models\Db;
use PHPUnit\Framework\TestCase;
// use Tests\TestCase;
use Mockery;


require_once __DIR__ . '/../../vendor/autoload.php';

class DbTest extends TestCase
{


    protected function setUp(): void
    {

        $servername = "localhost";
        $username = "admin";
        $password = "93072394";
        $dbname = "password_manager";

        $conn = new \mysqli($servername, $username, $password, $dbname);

        $sqlDelete = "DELETE FROM users WHERE NOT user_id <> 1";
        $sqlReset = "ALTER TABLE users AUTO_INCREMENT = 1";
        $sqlInsert = "INSERT INTO users (user_id, username, master_password, email) 
              VALUES (1, 'test', '$2y$12$7sEnjfIiw0hLglZOiZKh9u9xnH449Z.BDMaC/eomVInb.97/YRs4C', 'test@example.com')";

        $conn->query($sqlDelete);
        $conn->query($sqlReset);
        $conn->query($sqlInsert);

        $conn->close();
    }
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testFetchAll()
    {
        $mysqli = Mockery::mock('overloadAll');
        $mysqliResult = Mockery::mock('overloadAll');

        $mysqli->shouldReceive('query')->with('SELECT * FROM users')
            ->andReturn($mysqliResult);

        $mysqliResult->shouldReceive('fetch_all')->with(MYSQLI_ASSOC)
            ->andReturn([['id' => 1, 'username' => 'teste']]);

        $db = new Db();
        $result = $db->fetchAll("SELECT * FROM users");

        $this->assertIsArray($result);
        $this->assertEquals('test', $result[0]['username']);
    }

    public function testFetchOne()
    {
        $mysqli = Mockery::mock('overloadAll');
        $mysqliResult = Mockery::mock('overloadAll');

        $mysqli->shouldReceive('query')
            ->with('SELECT * FROM users WHERE user_id= 1')
            ->andReturn($mysqliResult);

        $expectedResult = [
            'user_id' => 1,
            'username' => 'test',
            'master_password' => '$2y$12$7sEnjfIiw0hLglZOiZKh9u9xnH449Z.BDMaC/eomVInb.97/YRs4C',
            'email' => 'test@example.com'
        ];
        $mysqliResult->shouldReceive('fetch_assoc')
            ->with(MYSQLI_ASSOC)
            ->andReturn($expectedResult);

        $db = new Db();
        $result = $db->fetchOne('SELECT * FROM users WHERE user_id=1');
        $this->assertIsArray($result);
        $this->assertEquals($result, $expectedResult);

        $mysqli->shouldReceive('query')
            ->with('SELECT * FROM users WHERE user_id=1000')
            ->andReturn(false);

        $result = $db->fetchOne('SELECT * FROM users WHERE user_id=1000');

        $this->assertNull($result);
    }

    public function testPrepareAndExecute()
    {
        $mysqli = Mockery::mock('overloadAll');
        $stmt = Mockery::mock('overloadAll');

        $mysqli->shouldReceive('prepare')
            ->with('INSERT INTO users (username, email, master_password) VALUES (?, ?, ?)')
            ->andReturn($stmt);

        $stmt->shouldReceive('bind_param')->with('testUser', 'testUser@example.com', '123456789')
            ->andReturn(true);

        $stmt->shouldReceive('execute')->andReturn(true);

        $db = new Db();
        $result = $db->prepareAndExecute('INSERT INTO users (username, email, master_password)
         VALUES (?, ?, ?)', 'sss', 'testUser', 'testUser@example.com', '123456789');
        $this->assertInstanceOf(\mysqli_stmt::class, $result);
    }

    public function testFetchPrepared()
    {
        $stmt = Mockery::mock('mysqli_stmt');

        $mysqliResult = Mockery::mock('mysqli_result');

        $stmt->shouldReceive('get_result')->andReturn($mysqliResult);

        $mysqliResult->shouldReceive('fetch_assoc')->andReturn(['id' => 1, 'username' => 'teste']);

        $db = new Db();

        $result = $db->fetchPrepared($stmt);

        $this->assertIsArray($result);
    }
}
