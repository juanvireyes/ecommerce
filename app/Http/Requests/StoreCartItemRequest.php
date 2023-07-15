<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productId' => 'required',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'productId.required' => 'El producto es requerido',
            'quantity.required' => 'La cantidad es requerida',
            'quantity.integer' => 'La cantidad debe ser un número entero',
        ];
    }
}
