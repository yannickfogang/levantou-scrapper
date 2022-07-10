<?php

namespace Tests\Feature\Login;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Infrastructure\Auth\PasswordProviderLaravel;
use Tests\TestCase;

class LoginUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        User::factory()->create(['email' => 'test@gmail.com', 'password' => (new PasswordProviderLaravel())->crypt('123456')]);
    }

    public function test_user_can_login() {
        $response = $this->postJson('/login', ['email' => 'test@gmail.com', 'password' => '123456']);
        $response->assertStatus(200)
            ->assertJson(
                ['message' => 'Utilisateur connecté', 'isLogged' => true]
            );
    }

    public function test_user_login_with_invalide_email_credentials() {
        $response = $this->postJson('/login', ['email' => 'tests@gmail.com', 'password' => '123456']);
        $response->assertStatus(200)
            ->assertJson(
                ['message' => 'Login ou mot de passe incorrect', 'isLogged' => false]
            );
    }

    public function test_user_login_with_invalide_password_credentials() {
        $response = $this->postJson('/login', ['email' => 'test@gmail.com', 'password' => '12345456']);
        $response->assertStatus(200)
            ->assertJson(
                ['message' => "Votre mot de passe n'est pas valide", 'isLogged' => false]
            );
    }

    public function test_user_can_login_with_invalide_email() {
        $response = $this->postJson('/login', ['email' => 'testgmail.com', 'password' => '123456']);
        $response->assertStatus(200)
                ->assertJson(['email' => ["Votre adresse email n'est pas valide"]]);
    }

    public function test_user_login_with_empty_email() {
        $response = $this->postJson('/login', ['email' => '', 'password' => '123456']);
        $response->assertStatus(200)
                ->assertJson(['email' => ['Veuillez entrer votre adresse email']]);
    }

    public function test_user_login_with_empty_password() {
        $response = $this->postJson('/login', ['email' => 'testes@gmail.com', 'password' => '']);
        $response->assertStatus(200)
            ->assertJson(['password' => ['Veuillez entrer votre mot de passe']]);
    }

}