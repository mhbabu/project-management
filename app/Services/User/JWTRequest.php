<?php

namespace App\Services\User;

use App\Models\User;

class JWTRequest
{
    private static $instance;

    private function __construct(public readonly User $user)
    {
    }

    public static function loadJWTAndSaveUser(): self
    {
        $payload = JWTPayload::load();
        return self::saveUser($payload->getUser());
    }

    public static function saveUser(User $user): self
    {
        if (!self::$instance) {
            self::$instance = new self($user);
        }

        return self::$instance;
    }

    public static function getUser(): ?User
    {
        return self::$instance->user;
    }
}