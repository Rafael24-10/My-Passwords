<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends User
{
    public function allUsers(): array
    {
        return $this->all();
    }

    public function userGet(int $id)
    {
        return $this->fetchUser($id);
    }

    public function userCreate(array $data): int
    {
        return $this->createUser($data);
    }

    public function userLogin(array $data): int
    {
        return $this->login($data);
    }

    public function userUpdate(int $id, array $data): int
    {
        return $this->updateUser($id, $data);
    }

    public function userDelete(int $id): int
    {
        return $this->destroyUser($id);
    }
}
