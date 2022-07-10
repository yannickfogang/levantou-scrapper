<?php

namespace Tests\Feature\Login;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Auth\useCases\Login\LoginUser;
use Module\Infrastructure\Auth\AuthRepositoryEloquent;
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

    public function setUp(): void
    {
        parent::setUp();
        $this->authRepository = new AuthRepositoryEloquent();
        $this->defaultUser = User::factory()->create(['email' => 'test@gmail.com', 'password' => '123456']);
    }

    public function test_user_can_login() {

        $loginCommand = LoginCommandBuilder::asLogin()
            ->withEmail($this->defaultUser->email)
            ->withPassword($this->defaultUser->password)
            ->build();
        $loginUser = new LoginUser($this->authRepository);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertNotNull($loginResponse->auth);
        $this->assertTrue($loginResponse->auth?->isLogged());
        $this->assertEquals($this->defaultUser->email, $loginResponse->auth?->getEmail());
    }

    public function test_user_login_with_wrong_credentials() {
        $loginCommand = LoginCommandBuilder::asLogin()
            ->withEmail('teste@gmail.com')
            ->build();
        $loginUser = new LoginUser($this->authRepository);
        $loginResponse = $loginUser->__invoke($loginCommand);
        $this->assertNotNull($loginResponse->auth);
        $this->assertFalse($loginResponse->auth?->isLogged());
    }
}
