<?php

namespace App\Traits;

trait AuthenticationTrait
{
    protected function isAuthenticated(): bool
    {
        return isset($_SESSION["user_id"]);
    }
}
