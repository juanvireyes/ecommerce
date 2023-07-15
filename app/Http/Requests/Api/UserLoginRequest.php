<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El email es requerido',
            'email.email' => 'Este no es un correo válido',
            'password.required' => 'La contraseña es requerida'
        ];
    }
}
