<?php

namespace Tests\Unit\Login;

use Module\Application\Auth\Login\LoginCommand;

class LoginCommandBuilder extends LoginCommand
{
    public string $email = 'test@gmail.com';
    public string $password = '123456';

    public static function asLogin(): LoginCommandBuilder {
        return new static();
    }

    public function withEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function withPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return LoginCommand
     */
    public function build(): LoginCommand
    {
        $loginCommand = new LoginCommand();
        $loginCommand->email = $this->email;
        $loginCommand->password = $this->password;
        return $loginCommand;
    }

}
