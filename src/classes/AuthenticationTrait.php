<?php

namespace App\Traits;

trait AuthenticationTrait
{
    protected function isAuthenticated(int $userId): bool
    {
        return isset($_SESSION["user_id"]) && $_SESSION["user_id"] ===  $userId;
    }
}
