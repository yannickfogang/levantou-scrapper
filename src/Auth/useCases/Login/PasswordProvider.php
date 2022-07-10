<?php

namespace Module\Auth\useCases\Login;

interface PasswordProvider
{
    public function crypt(string $password) : string;
    public function check(string $password, string $passwordHash): bool;
}
