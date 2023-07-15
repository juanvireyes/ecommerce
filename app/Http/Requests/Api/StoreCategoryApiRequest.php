<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'unique:categories,name', 'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'order' => 'integer|unique:categories,order',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'El nombre solo puede contener letras y espacios',
            'name.unique' => 'Este nombre de categoría ya existe',
            'order.unique' => 'El orden en el display que quieres asignar ya está ocupado',
            'image.max' => 'El tamaño máximo permitido es 2MB',
            'image.mimes' => 'El formato de la imagen debe ser jpeg, png o jpg'
        ];
    }
}
