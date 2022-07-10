<?php

namespace Tests\Unit\Login;

use Module\Auth\Exceptions\ErrorAuthException;
use Module\Auth\useCases\Login\LoginCommand;
use Module\Auth\useCases\Login\LoginUser;
use Module\Infrastructure\Auth\AuthRepositoryInMemory;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    private AuthRepositoryInMemory $authRepository;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->authRepository = new AuthRepositoryInMemory();
    }

    public function test_user_can_login() {

        $loginCommand = LoginCommandBuilder::asLogin()->build();
        $loginUser = new LoginUser($this->authRepository);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertTrue($loginResponse->auth->isLogged());
        $this->assertEquals('Utilisateur connecté', $loginResponse->auth?->loggedMessage());
    }

    public function test_user_login_with_wrong_credentials() {
        $loginCommand = LoginCommandBuilder::asLogin()
            ->withEmail('tessdqsdqsd@qsdqsd.qsdqsd')
            ->build();
        $loginUser = new LoginUser($this->authRepository);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertFalse($loginResponse->auth->isLogged());
        $this->assertEquals("Login ou mot de passe incorrect", $loginResponse->auth?->loggedMessage());
    }

    public function test_user_login_with_wrong_password() {
        $loginCommand = LoginCommandBuilder::asLogin()
            ->withPassword('azeazeazeaze')
            ->build();
        $loginUser = new LoginUser($this->authRepository);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertFalse($loginResponse->auth?->isLogged());
        $this->assertEquals("Votre mot de passe n'est pas valide", $loginResponse->auth?->loggedMessage());
    }

    public function test_user_login_with_invalid_email() {
        $loginCommand = LoginCommandBuilder::asLogin()
            ->withEmail('qdsdsfsdfsdf')
            ->build();
        $loginUser = new LoginUser($this->authRepository);
        $this->expectException(ErrorAuthException::class);
        $this->expectExceptionMessage("Cet adresse email : $loginCommand->email n'est pas valide");
        $loginResponse = $loginUser->__invoke($loginCommand);
    }

    public function test_user_login_with_invalid_password() {
        $loginCommand = LoginCommandBuilder::asLogin()
            ->withPassword('')
            ->build();
        $loginUser = new LoginUser($this->authRepository);
        $this->expectException(ErrorAuthException::class);
        $this->expectExceptionMessage("Votre mot de passe n'est pas valide");
        $loginResponse = $loginUser->__invoke($loginCommand);
    }
}
