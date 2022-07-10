<?php
declare(strict_types=1);

namespace Module\Auth\useCases\Login;

use Module\Auth\Exceptions\ErrorAuthException;

final class LoginUser
{

    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository) {
        $this->authRepository = $authRepository;
    }

    /**
     * @param LoginCommand $loginCommand
     * @return LoginResponse
     */
    public function __invoke(LoginCommand $loginCommand): LoginResponse {
        $response = new LoginResponse();
        $auth = Auth::compose($loginCommand->email, $loginCommand->password);
        $authResult = $this->authRepository->getByCredentials($auth);
        $auth->login($authResult);
        $response->auth = $auth;
        return $response;
    }

}
