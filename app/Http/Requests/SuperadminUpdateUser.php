<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuperadminUpdateUser extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cellphone' => 'required|string|max:40',
            'address' => 'string|max:150',
            'city' => 'string|max:80',
            'state' => 'string|max:80',
            'country' => 'string|max:80',
        ];
    }

    public function messages()
    {
        return [
            'cellphone.required' => 'El número de teléfono celular no puede ir vacío',
            'cellphone.max' => 'El número de teléfono celular no puede superar los 40 caracteres',
            'address.max' => 'La dirección no puede superar los 150 caracteres',
            'city' => 'El nombre de la ciudad no puede superar los 80 caracteres',
            'state' => 'El nombre del Estado/Departamento no puede superar los 80 caracteres',
            'country' => 'El nombre del país no puede superar los 80 caracteres'
        ];
    }
}
