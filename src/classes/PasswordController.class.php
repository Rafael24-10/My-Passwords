<?php

namespace App\Controller;

use App\Models\Password;

class PasswordController extends Password
{
    public function userPasswords(int $id): array
    {
        return $this->fetchPasswordsFromUser($id);
    }

    public function passwordCreate(array $data): int
    {
        return $this->createPassword($data);
    }

    public function passwordUpdate(int $passwordId, array $data): int
    {
        return $this->updatepassword($passwordId, $data);
    }

    public function passwordDelete(int $passwordId): int
    {
        return $this->destroyPassword($passwordId);
    }
}
