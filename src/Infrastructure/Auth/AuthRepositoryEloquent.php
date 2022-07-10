<?php

namespace Module\Infrastructure\Auth;

use App\Models\User;
use Module\Auth\useCases\Login\Auth;
use Module\Auth\useCases\Login\AuthRepository;
use Module\Auth\useCases\Login\AuthResult;

class AuthRepositoryEloquent implements AuthRepository
{

    public function getByCredentials(Auth $auth): AuthResult
    {
        $user = User::whereEmail($auth->getEmail())->first();
        if ($user) {
            return new AuthResult($user->email, $user->password);
        }
        return new AuthResult(null, null);
    }

}
