<?php

namespace Tests\Feature\Login;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Application\Auth\Login\LoginUser;
use Module\Infrastructure\Auth\AuthRepositoryEloquent;
use Module\Infrastructure\Auth\PasswordProviderLaravel;
use Module\Infrastructure\Auth\PasswordProviderMemory;
use Tests\TestCase;
use Tests\Unit\Login\LoginCommandBuilder;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    private AuthRepositoryEloquent $authRepository;
    /**
     * @var Collection|HasFactory|Model|mixed
     */
    private mixed $defaultUser;
    private PasswordProviderMemory $passwordAuth;
    private PasswordProviderLaravel $passwordProvider;

    public function setUp(): void
    {
        parent::setUp();
        $this->authRepository = new AuthRepositoryEloquent();
        $this->passwordProvider = new PasswordProviderLaravel();
        $this->defaultUser = User::factory()
            ->create(
                [
                    'email' => 'test@gmail.com',
                    'password' => $this->passwordProvider->crypt('123456')
                ]
            );
    }

    public function test_user_can_login() {

        $loginCommand = LoginCommandBuilder::asLogin()
            ->withEmail($this->defaultUser->email)
            ->withPassword('123456')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertNotNull($loginResponse->auth);
        $this->assertTrue($loginResponse->auth?->isLogged());
        $this->assertEquals($this->defaultUser->email, $loginResponse->auth?->getEmail());
    }

    public function test_user_login_with_wrong_credentials() {
        $loginCommand = LoginCommandBuilder::asLogin()
            ->withEmail('teste@gmail.com')
            ->build();
        $loginUser = new LoginUser($this->authRepository, $this->passwordProvider);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertNotNull($loginResponse->auth);
        $this->assertFalse($loginResponse->auth?->isLogged());
    }
}
