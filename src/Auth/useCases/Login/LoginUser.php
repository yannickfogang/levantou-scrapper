<?php
declare(strict_types=1);

namespace Module\Auth\useCases\Login;

class LoginUser
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

        $user = $this->authRepository->getByCredentials($loginCommand->email, $loginCommand->password);

        if (!$user) {
            $response->message = 'Cet utilisateur n\'existe pas';
            return $response;
        }

        $response->isLogged = true;
        $response->message = 'Utilisateur connecté';
        return $response;
    }
}
