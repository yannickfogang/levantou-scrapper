<?php

namespace Module\Auth\useCases\Login;

class LoginResponse
{
    public bool $isLogged = false;
    public string $message;
}
