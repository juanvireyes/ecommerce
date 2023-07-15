<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Unique;

/**
 * @property mixed $product
 */
class UpdateProductApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => 'required|integer|min:0',
            'order' => [
                'integer',
                $uniqueOrder->ignore($this->product->id),
                'nullable',
                'min:0'
            ],
            'subcategory_id' => 'required|integer|min:1|exists:subcategories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre no puede ir vacío, es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre no puede superar los 100 caracteres',
            'image.file' => 'La imagen debe ser un archivo',
            'image.mimes' => 'La extensión del archivo no es válida (debe ser JPG, JPEG o PNG)',
            'image.max' => 'La imagen no debe superar los 2MB',
            'price.required' => 'EL precio no puede ir vacío',
            'price.numeric' => 'El precio debe ser un número, no se admiten letras',
            'price.min' => 'El precio no puede ser inferior a 0',
            'stock.required' => 'La cantidad de producto no puede ir vacía',
            'stock.integer' => 'La cantidad de producto debe ser un número entero',
            'stock.min' => 'La cantidad de producto no puede ser menor a 0',
            'order.integer' => 'El orden debe ser un número entero',
            'order.min' => 'El orden no puede ser menor a 0',
            'subcategory_id.required' => 'La subcategoría no puede ir vacía',
            'subcategory_id.integer' => 'El id de la subcategoría debe ser un número entero',
            'subcategory_id.min' => 'El id de la categoría no puede ser menor a 1',
            'subcategory_id.exists' => 'La subcategoría seleccionada no existe'
        ];
    }
}
