<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubcategoryRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'unique:categories,name', 'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'order' => 'integer|unique:categories,order',
            'category_id' => 'integer|exists:categories,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.regex' => 'El nombre de la subcategoría sólo puede contener letras y espacios',
            'name.unique' => 'La subcategoría ya existe',
            'image.mimes' => 'El archivo debe ser una imagen y sólo acepta formatos jpeg, png y jpg',
            'image.max' => 'El tamaño máximo del archivo es de 2MB',
            'order.unique' => 'El orden de la subcategoría ya existe',
            'category_id.exists' => 'La categoría que intentaste seleccionar no existe',
        ];
    }
}
