<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:80'],
            'last_name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:80'],
            'id_number' => 'required|string|max:12',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'cellphone' => 'required|string|regex:/^[+0-9\-]{10,15}$/',
            'address' => 'required|string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => 'Los nombres sólo pueden contener letras y espacios',
            'last_name.regex' => 'Los apellidos sólo pueden contener letras y espacios',
            'cellphone.regex' => 'El número de celular solo puede contener números y guiones y debe tener entre 10 y 15 caracteres',
        ];
    }
}
