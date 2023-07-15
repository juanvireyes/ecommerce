<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductsImportApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productsList' => 'required|file|mimes:xlsx,csv,xls,ods|max:15360'
        ];
    }

    public function messages()
    {
        return [
            'productsList.required' => 'Es necesario adjuntar un archivo',
            'productsList.file' => 'Lo que adjuntaste no es un archivo',
            'productsList.mimes' => 'EL formato del archivo debe ser xlsx, csv, xls u ods',
            'productsList.max' => 'El tamaño del archivo no puede superar los 15MB'
        ];
    }
}
