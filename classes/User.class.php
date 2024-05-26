<?php

class User extends Db
{

    protected function all(): array
    {
        $sql = "Select * from users";
        return $this->fetchAll($sql);
    }

    protected function fetchUser(int $id): array
    {
        $sql = "Select * from users where id=$id";
        return $this->fetchOne($sql);
    }

    protected function createUser(array $data): int
    {
        $username = $data["username"];
        $email = $data["email"];
        $password = $data["master_password"];
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $this->prepareAndExecute($sql, "ss", $username, $email);

        if ($stmt->num_rows > 0) {

            $stmt->close();
            return 1; //Código de erro para usuário ou email já existente
        }

        $insertQuery = "INSERT INTO users (username, master_password, email) VALUES(?, ?, ?)";
        $stmt = $this->prepareAndExecute($insertQuery, "sss", $username, $email, $password);

        if ($stmt) {
            $stmt->close();
            return 0; //Código de sucesso
        } else {
            return 2; //Código de erro para falha na inserção
        }
    }

    protected function login(array $data): int
    {
        $username = $data["username"];
        $password = $data["master_password"];
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->prepareAndExecute($sql, "s", $username);

        if ($stmt->num_rows === 1) {

            $row = $this->fetchPrepared($stmt);

            if (password_verify($password, $row["master_password"])) {
                session_start();
                $_SESSION["user_id"] = $row["user_id"];
                return 0; //Código de sucesso
            } else {
                return 2; //Código de erro para senha incorreta
            }
        } else {
            return 1; //Código de erro para usuário não encontrado
        }
    }

    protected function updateUser(int $id, array $data): int
    {
        //todo: validar os inputs no usuário no controlador 
        //antes de passar para esse método

        $updateString = "";

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $value = "'$value'";
            }

            $updateString .= "$key = $value,";
            $updateString = rtrim($updateString, ', ');
        }

        $sql = "UPDATE users SET $updateString WHERE user_id = ?";
        $stmt = $this->prepareAndExecute($sql, "i", $id);

        if ($stmt) {
            $stmt->close();
            return 0; //Usuário atualizado
        }

        return 1; //Erro ao atualizar
    }

    protected function destroyUser($id): int
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->prepareAndExecute($sql, "i", $id);
        
        if ($stmt) {
            return 0; //Usuário deletado
        } else {
            return 1; //Erro ao deletar
        }
    }
}
