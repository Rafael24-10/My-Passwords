<?php

namespace App\Models;

use Termwind\Components\Dd;

class Db
{
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $database = "database";
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function query($sql)
    {
        $result = $this->conn->query($sql);
        if ($this->conn->error) {
            die("Query error: " . $this->conn->error);
        }
        return $result;
    }

    public function fetchAll($sql)
    {
        $result = $this->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function fetchOne($sql)
    {
        $result = $this->query($sql);

        if ($result === false || $result->num_rows === 0) {
            return false;
        } else {
            return $result->fetch_assoc();
        }
    }

    public function prepareAndExecute($sql, $types, ...$params)
    {
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            return false;
        }

        return $stmt;
    }

    public function fetchPrepared($stmt)
    {
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
