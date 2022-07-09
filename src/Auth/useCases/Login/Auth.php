<?php

namespace Module\Auth\useCases\Login;

use Module\Auth\Exceptions\ErrorAuthException;

class Auth
{
    private string $email;
    private string $password;

    private function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
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

    public function login(AuthResult $authResult, LoginResponse $response): LoginResponse
    {
        if (!$authResult->getEmail()) {
            $response->message = 'Login ou mot de passe incorrect';
            return $response;
        }

        if ($authResult->getPassword() !== $this->password) {
            $response->message = "Votre mot de passe  n'est pas valide";
            return $response;
        }

        $response->message = 'Utilisateur connecté';
        $response->isLogged = true;
        return $response;
    }


}
