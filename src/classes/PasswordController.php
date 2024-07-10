<?php

namespace App\Controllers;

use App\Models\Password;
use App\Traits\EncryptionTrait;

class PasswordController extends Password
{
    use EncryptionTrait;

    public function userPasswords(int $id): array
    {
        return $this->fetchPasswordsFromUser($id);
    }

    public function passwordCreate(array $data): int
    {
        $userController = new UserController();
        $key = $userController->userGet($data['user_id']);
        $data['password_value'] = $this->encryptWithOpenSSL($data['password_value'], $key['master_password']);
        $create =  $this->createPassword($data);
        switch ($create) {
            case 0:
                header("Location: dashboard.php");
                return 0;

            case 1:
                echo "<script>
         alert('There was an error creating your password. Try again later');
         window.location.href = 'dashboard.php';
       </script>";
                return 1;
        }
    }

    public function passwordUpdate(int $passwordId, array $data): int
    {
        $update = $this->updatepassword($passwordId, $data);

        switch ($update) {
            case 0:
                header("location: dashboard.php");
                return 0;

            case 1:
                echo "<script>
            alert('There was an error editing your password. Try again later');
            window.location.href = 'dashboard.php';
          </script>";
                return 1;
        }
    }

    public function passwordDelete(int $passwordId): int
    {
        $delete =  $this->destroyPassword($passwordId);

        switch ($delete) {
            case 0:
                header("Location: dashboard.php");
                return 0;

            case 1:
                echo "<script>
            alert('There was an error deleting your password. Try again later');
            window.location.href = 'dashboard.php';
          </script>";
                return 1;
        }
    }
}
