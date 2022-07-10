<?php
declare(strict_types=1);

namespace Module\Auth\useCases\Login;

use Module\Auth\Exceptions\ErrorAuthException;

final class LoginUser
{

    private AuthRepository $authRepository;
    private PasswordProvider $passwordProvider;

    public function __construct(AuthRepository $authRepository, PasswordProvider $password) {
        $this->authRepository = $authRepository;
        $this->passwordProvider = $password;
    }

    /**
     * @param LoginCommand $loginCommand
     * @return LoginResponse
     */
    public function __invoke(LoginCommand $loginCommand): LoginResponse {
        $response = new LoginResponse();
        $auth = Auth::compose($loginCommand->email, $loginCommand->password, $this->passwordProvider);
        $authResult = $this->authRepository->getByCredentials($auth);
        $auth->login($authResult);
        $response->auth = $auth;
        return $response;
    }

}
