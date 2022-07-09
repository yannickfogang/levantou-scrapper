<?php
declare(strict_types=1);

namespace Module\Auth\useCases\Login;

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

        if(!$loginCommand->email || !$loginCommand->password) {
            $response->message = 'Ces paramètres ne sont pas renseignés';
            return $response;
        }

        list($status, $message) = $this->authRepository->getByCredentials($loginCommand->email, $loginCommand->password);

        if (!$status) {
            $response->message = $message;
            return $response;
        }

        $response->isLogged = true;
        $response->message = $message;
        return $response;
    }

}
