<?php

namespace App\ViewModel;

use Illuminate\Http\JsonResponse;
use Module\Auth\useCases\Login\LoginResponse;

class LoginUserViewModel extends ViewModel
{
    public string $message;
    public bool $isLogged;

    public function __construct()
    {
        $this->isLogged = false;
        $this->message = '';
    }

    public function present(LoginResponse $response): void
    {
        $auth = $response->auth;
        $this->message = $auth?->loggedMessage();
        $this->isLogged = $auth?->isLogged();
    }

    /**
     * @return JsonResponse
     */
    public function viewModel(): JsonResponse
    {
        return $this->response(
            [
                'isLogged' => $this->isLogged,
                'message' => $this->message
            ]
        );
    }
}
