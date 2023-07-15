<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

/**
 * @property mixed $subcategory
 */
class UpdateSubcategoryApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uniqueName = new Unique('subcategories', 'name');
        $uniqueOrder = new Unique('subcategories', 'order');
        return [
            'name' => [
                'string',
                'regex:/^[\pL\s]+$/u',
                $uniqueName->ignore($this->subcategory->id),
                'max:100'
            ],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'order' => ['integer', $uniqueOrder->ignore($this->subcategory->id)],
            'category_id' => 'integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'El nombre sólo puede contener letras y espacios',
            'name.max' => 'El nombre no puede superar los 100 caracteres',
            'image.file' => 'La imagen debe ser un archivo',
            'image.mimes' => 'La imagen debe ser una imagen con formatos jpg, png o jpeg',
            'image.max' => 'La imagen no puede superar los 2MB',
            'category_id.exists' => 'La categoría que seleccionaste no existe'
        ];
    }
}
