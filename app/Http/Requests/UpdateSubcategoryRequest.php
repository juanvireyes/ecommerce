<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

/**
 * @property mixed $subcategory
 */
class UpdateSubcategoryRequest extends FormRequest
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
                'required',
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
}
