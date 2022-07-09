<?php

namespace Module\Auth\Exceptions;


final class ErrorAuthException extends \RuntimeException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function withEmailOf(string $email): self
    {
        return new self($email);
    }

    public static function withPasswordOf(string $password): self
    {
        return new self($password);
    }
}
