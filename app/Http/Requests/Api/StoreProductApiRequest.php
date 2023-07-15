<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductApiRequest extends FormRequest
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
            'image' => 'file|mimes:jpg,jpeg,png|max:2048|nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'order' => 'integer|unique:products,order|min:0|nullable',
            'subcategory_id' => 'required|integer|exists:subcategories,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es requerido',
            'descripcion' => 'La descripción debe ser una cadena de texto',
            'image.file' => 'La imagen debe ser un archivo',
            'image.mimes' => 'La extensión de la imagen no es válida. Sólo se aceptan PNG, JPG o JPEG',
            'image.max' => 'El tamaño de la imagen no debe superar los 2MB',
            'price' => 'EL precio es requerido',
            'price.numeric' => 'El valor del precio no es válido',
            'price.min' => 'El valor del precio no es válido',
            'stock.required' => 'La cantidad de producto es requerida',
            'stock.integer' => 'La cantidad del producto debe ser un entero',
            'stock.min' => 'La cantidad del producto no puede ser inferior a 0',
            'order.integer' => 'El orden debe ser un número entero',
            'order.unique' => 'Este número para el orden ya existe, elige otro',
            'order.min' => 'El orden no puede ser inferior a 0',
            'subcategory_id.required' => 'La subcategoría es requerida',
            'subcategory_id.exists' => 'La subcategoría que intentas asignar no existe'
        ];
    }
}
