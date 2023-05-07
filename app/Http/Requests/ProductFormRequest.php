<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:categories,name', 'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'price' => ['required', 'numeric'],
            'stock' => 'required|integer|min:0',
            'order' => 'required|integer|min:0|nullable',
            'subcategory_id' => 'required|integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'El nombre no puede tener más de 100 caracteres',
            'name.unique' => 'El nombre ya existe',
            'name.required' => 'El nombre es requerido',
            'image.file' => 'El archivo no es una imagen',
            'image.mimes' => 'El archivo no tiene un formato válido. Sólo se permiten jpeg, jpg y png',
            'price' => 'El precio es requerido',
            'price.numeric' => 'El precio debe ser numérico',
            'stock' => 'El stock es requerido',
            'subcategory_id' => 'La subcategoría es requerida'
        ];
    }
}
