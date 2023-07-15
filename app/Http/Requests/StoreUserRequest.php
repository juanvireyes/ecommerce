<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:80'],
            'last_name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'max:80'],
            'id_number' => 'required|string|max:12',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'cellphone' => 'required|string|regex:/^[+0-9\-]{10,15}$/',
            'address' => 'string|max:150|nullable',
            'city' => 'string|max:80|nullable',
            'state' => 'string|max:80|nullable',
            'country' => 'string|max:80|nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Los nombres son requeridos',
            'first_name.regex' => 'Los nombres sólo pueden contener letras y espacios',
            'first_name.max' => 'Los nombres no pueden superar los 80 caracteres',
            'last_name.required' => 'Los apellidos no pueden ir vacíos',
            'last_name.regex' => 'Los apellidos sólo pueden contener letras y espacios',
            'last_name.max' => 'Los apellidos no pueden superar los 80 caracteres',
            'email.required' => 'El email es requerido',
            'email.unique' => 'Este email ya existe',
            'password.required' => 'Debes proporcionar una contraseña',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'cellphone.required' => 'El número de teléfono es requerido',
            'cellphone.regex' => 'El número de celular solo puede contener números y guiones y debe tener entre 10 y 15 caracteres',
            'address.max' => 'La dirección no puede superar los 150 caracteres',
            'city.max' => 'El nombre de tu ciudad no puede superar los 80 caracteres',
            'state.max' => 'El nombre del Estado o Departamento no puede superar los 80 caracteres',
            'country.max' => 'El nombre del país no debe superar los 80 caracteres'
        ];
    }
}
