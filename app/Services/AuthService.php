<?php

namespace App\Services;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function createToken(User $user)
    {
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return $tokenResult;
    }

    public function checkAccount(string $email, string $password)
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function removeCurrentAccessToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
