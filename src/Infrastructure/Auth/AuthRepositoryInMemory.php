<?php

namespace Module\Infrastructure\Auth;

use Module\Auth\useCases\Login\Auth;
use Module\Auth\useCases\Login\AuthRepository;
use Module\Auth\useCases\Login\AuthResult;

class AuthRepositoryInMemory implements AuthRepository
{
    /**
     * @var UserInMemory[]
     */
    private array $users = [];

    public function __construct()
    {
        $this->users[] = new UserInMemory('test@gmail.com', '123456');
        $this->users[] = new UserInMemory('test1@gmail.com', '123456');
        $this->users[] = new UserInMemory('test2@gmail.com', '123456');
    }

    public function getByCredentials(Auth $auth): AuthResult
    {
        $userIn = null;
        foreach ($this->users as $user) {
            if ($user->getEmail() === $auth->getEmail()) {
                $userIn = $user;
                break;
            }
        }
        if ($userIn) {
            return new AuthResult($userIn->getEmail(), $userIn->getPassword());
        }
        return new AuthResult(null, null);
    }

}


class UserInMemory {
    private string $email;
    private string $password;
    public function __construct(string $email, string $password) {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


}
