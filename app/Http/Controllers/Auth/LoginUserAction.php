<?php

namespace App\Http\Controllers\Auth;

use App\Factories\LoginUserFactory;
use App\Http\Request\LoginUserRequest;
use App\ViewModel\LoginUserViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Module\Application\Auth\Login\LoginCommand;
use Module\Application\Auth\Login\LoginUser;
use Module\Domain\Auth\Exceptions\ErrorAuthException;

class LoginUserAction
{
    public function __invoke(
        LoginUserRequest $request,
        LoginUser $loginUser
    ): RedirectResponse
    {
        $viewModel = new LoginUserViewModel();
        $loginCommand = LoginUserFactory::buildLoginCommandFromRequest($request);
        try {
            $response = $loginUser->__invoke($loginCommand);
            $viewModel->present($response);
            $this->AuthLogin($loginCommand, $response->auth?->isLogged());
        } catch (ErrorAuthException $e) {
            $viewModel->message = $e->getMessage();
        }

        if ($viewModel->isLogged) {
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }


    private function AuthLogin(LoginCommand $loginCommand, bool $isLogged): void
    {
        if ($isLogged) {
             Auth::attempt(['email' => $loginCommand->email, 'password' => $loginCommand->password]);
        }
    }

}
