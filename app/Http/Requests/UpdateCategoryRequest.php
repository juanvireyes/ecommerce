<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $uniqueName = new Unique('categories', 'name');
        $uniqueOrder = new Unique('categories', 'order');
        return [
            'name' => [
                'required', 
                'string', 
                'regex:/^[\pL\s]+$/u', 
                $uniqueName->ignore($this->category->id), 
                'max:100'],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'order' => ['integer', $uniqueOrder->ignore($this->category->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'El nombre solo puede contener letras y espacios',
            'image.max' => 'El tamaño máximo permitido es 2MB',
            'image.mimes' => 'El formato de la imagen debe ser jpeg, png o jpg'
        ];
    }
}
