<?php

class Password extends Db
{
    protected function fetchPasswordsFromUser($id): array
    {
        $sql = "SELECT * FROM passwords WHERE user_id=$id ";
        $passwords = $this->fetchAll($sql);

        if ($passwords) {
            return $passwords;
        }
        return [];
    }

    protected function createPassword(array $data): int
    {
        $passwordName = $data["password_name"];
        $passwordValue = $data["password_value"];
        $sql = "SELECT * FROM passwords WHERE password_name = ? AND user_id = ?";
        $stmt = $this->prepareAndExecute($sql, "si", $passwordName, $passwordValue);

        if ($stmt) {
            $stmt->close();
            return 0;  //Senha criada com sucesso
        } else {
            return 1; //Falha ao criar senha
        }
    }

    protected function updatepassword()
    {
    }

    protected function destroyPassword()
    {
    }
}
