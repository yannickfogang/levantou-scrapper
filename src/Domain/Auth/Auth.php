<?php

namespace Module\Domain\Auth;

use Module\Domain\Auth\Exceptions\ErrorAuthException;

class Auth
{
    private string $email;
    private string $password;
    private bool $isLogged;
    private string $loggedMessage;
    private string $passwordHash;
    private PasswordProvider $passwordProvider;

    private function __construct()
    {
        $this->isLogged = false;
    }

    /**
     * @param string $email
     * @param string $password
     * @param PasswordProvider $passwordProvider
     * @return Auth
     */
    public static function compose(string $email, string $password, PasswordProvider $passwordProvider): Auth
    {

        $passwordHash = $passwordProvider->crypt($password);
        $self = new static($email, $password);
        $self->password = $password;
        $self->email = $email;
        $self->passwordProvider = $passwordProvider;
        $self->validateEmail();
        $self->validatePassword();

        return $self;
    }

    /**
     * @return void
     */
    private function validateEmail(): void
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new ErrorAuthException("Cet adresse email : $this->email n'est pas valide");
        }
    }

    /**
     * @return void
     */
    private function validatePassword(): void
    {
        if (!$this->password) {
            throw new ErrorAuthException("Votre mot de passe n'est pas valide");
        }
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param AuthResult $authResult
     * @return void
     */
    public function login(AuthResult $authResult): void
    {
        if (!$authResult->getEmail()) {
            $this->loggedMessage = 'Login ou mot de passe incorrect';
            return;
        }

        if (
            !$this->passwordProvider->check(
                $this->password,
                $authResult->getPassword()
            )
        ) {
            $this->loggedMessage = "Votre mot de passe n'est pas valide";
            return;
        }

        $this->loggedMessage = 'Utilisateur connecté';
        $this->isLogged = true;
    }

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->isLogged;
    }

    /**
     * @return string
     */
    public function loggedMessage(): string
    {
        return $this->loggedMessage;
    }

    /**
     * @return string
     */
    public function passwordHash(): string
    {
        return $this->passwordHash;
    }
}
