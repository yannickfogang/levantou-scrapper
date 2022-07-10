<?php

namespace Module\Auth\useCases\Login;

use Module\Auth\Exceptions\ErrorAuthException;

class Auth
{
    private string $email;
    private string $password;
    private bool $isLogged;
    private string $loggedMessage;

    private function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->isLogged = false;
    }

    /**
     * @param string $email
     * @param $password
     * @return Auth
     */
    public static function compose(string $email, $password): Auth
    {
        $self = new static($email, $password);
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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function login(AuthResult $authResult)
    {
        if (!$authResult->getEmail()) {
            $this->loggedMessage = 'Login ou mot de passe incorrect';
            return;
        }

        if ($authResult->getPassword() !== $this->password) {;
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

}
