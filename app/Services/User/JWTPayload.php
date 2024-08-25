<?php

namespace App\Services\User;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTPayload
{
    private readonly User $user;

    public function __construct(private readonly string $email)
    {
        $this->user = User::where('email', $this->email)->first();
    }


    public function getUser(): User
    {
        return $this->user;
    }

    public static function load()
    {
        $token   = JWTAuth::getToken();
        $payload = JWTAuth::getPayload($token);
        return new JWTPayload($payload['sub']);
    }
}