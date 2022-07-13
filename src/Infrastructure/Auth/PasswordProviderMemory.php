<?php

namespace Module\Infrastructure\Auth;

use Module\Domain\Auth\PasswordProvider;

class PasswordProviderMemory implements PasswordProvider
{
    public function crypt(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function check(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }
}
