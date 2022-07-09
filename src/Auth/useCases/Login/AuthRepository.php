<?php

namespace Module\Auth\useCases\Login;

interface AuthRepository
{
    public function getByCredentials(string $email, string $password): bool;
}
