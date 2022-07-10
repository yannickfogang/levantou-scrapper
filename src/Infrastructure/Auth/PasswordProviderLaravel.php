<?php

namespace Module\Infrastructure\Auth;

use Illuminate\Support\Facades\Hash;
use Module\Auth\useCases\Login\PasswordProvider;

class PasswordProviderLaravel implements PasswordProvider
{

    public function crypt(string $password): string
    {
        return Hash::make($password);
    }

    public function check(string $password, string $passwordHash): bool
    {
        return Hash::check($password, $passwordHash);
    }
}
