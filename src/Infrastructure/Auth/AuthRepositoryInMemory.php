<?php

namespace Module\Infrastructure\Auth;

use Module\Auth\useCases\Login\AuthRepository;

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

    public function getByCredentials(string $email, string $password): array
    {
        $userIn = null;
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                $userIn = $user;
                break;
            }
        }

        if (!$userIn) {
            return [false,'Login ou mot de passe incorrect'];
        }

        if ($userIn->getPassword() !== $password) {
            return [false, "Votre mot de passe  n'est pas valide"];
        }

        return [true, "Utilisateur connecté"];
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
