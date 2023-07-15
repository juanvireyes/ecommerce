<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductsFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productsFile' => 'required|mimes:xlsx,xls,csv,ods|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'productsFile.required' => 'Es necesario adjuntar un archivo',
            'productsFile.mimes' => 'El formato del archivo debe ser de tipo excel, cvs u ods',
            'productsFile.max' => 'El tamaño del archivo no puede superar los 2MB'
        ];
    }
}
