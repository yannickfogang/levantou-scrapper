<?php

namespace Module\Auth\useCases\Login;

interface AuthRepository
{
    public function getByCredentials(Auth $auth): AuthResult;
}
