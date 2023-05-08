<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Unique;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $uniqueName = new Unique ('products', 'name');
        $uniqueOrder = new Unique ('products', 'order');
        return [
            'name' => [
                'required', 
                'string', 
                $uniqueName->ignore($this->product->id), 
                'max:100'
            ],
            'description' => 'string|nullable',
            'image' => 'file|mimes:jpeg,png,jpg|max:2048|nullable',
            'price' => ['required', 'numeric'],
            'stock' => 'required|integer|min:0',
            'order' => [
                'required',
                'integer',
                $uniqueOrder->ignore($this->product->id),
                'nullable',
                'min:0'
            ],
            'subcategory_id' => 'required|integer|min:0'
        ];
    }
}
