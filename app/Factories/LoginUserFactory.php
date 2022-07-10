<?php

namespace App\Factories;

use Illuminate\Http\Request;
use Module\Auth\useCases\Login\LoginCommand;

class LoginUserFactory
{

    public static function buildLoginCommandFromRequest(Request $request): LoginCommand
    {
        $loginCommand = new LoginCommand();
        $loginCommand->email = $request->get('email');
        $loginCommand->password = $request->get('password');
        return $loginCommand;
    }
}
