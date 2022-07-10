<?php

namespace App\Http\Request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use JetBrains\PhpStorm\ArrayShape;

class LoginUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()), 200);
    }

    #[ArrayShape(['email.required' => "string", 'email.email' => "string", 'password.required' => "string"])]
    public function messages(): array
    {
        return [
            'email.required' => 'Veuillez entrer votre adresse email',
            'email.email' => "Votre adresse email n'est pas valide",
            'password.required' => 'Veuillez entrer votre mot de passe'
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['email' => "string", 'password' => "string"])]
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
