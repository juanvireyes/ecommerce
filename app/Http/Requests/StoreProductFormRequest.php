<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:products,name', 'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'price' => ['required', 'numeric'],
            'stock' => 'required|integer|min:0',
            'order' => 'required|integer|min:0|nullable',
            'subcategory_id' => 'required|integer|min:0|exists:subcategories,id'
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
            'subcategory_id.required' => 'La subcategoría es requerida',
            'subcategory_id.exists' => 'La subcategoría no existe'
        ];
    }
}
