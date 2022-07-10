<?php

namespace App\Http\Controllers\Auth;

use App\Factories\LoginUserFactory;
use App\ViewModel\LoginUserViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Module\Auth\Exceptions\ErrorAuthException;
use Module\Auth\useCases\Login\LoginCommand;
use Module\Auth\useCases\Login\LoginUser;

class LoginUserAction
{
    public function __invoke(
        Request   $request,
        LoginUser $loginUser
    ): JsonResponse
    {
        $viewModel = new LoginUserViewModel();
        $loginCommand = LoginUserFactory::buildLoginCommandFromRequest($request);
        try {
            $response = $loginUser->__invoke($loginCommand);
            $viewModel->present($response);
            $this->AuthLogin($response->auth);
        } catch (ErrorAuthException $e) {
            $viewModel->message = $e->getMessage();
        }
        return $viewModel->viewModel();
    }

    /**
     * @param \Module\Auth\useCases\Login\Auth|null $auth
     * @return void
     */
    private function AuthLogin(?\Module\Auth\useCases\Login\Auth $auth): void
    {
        if ($auth?->isLogged()) {
            Auth::attempt(['email' => $auth?->getEmail(), 'password' => $auth?->getPassword()]);
        }
    }

}
