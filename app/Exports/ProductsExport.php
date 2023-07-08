<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    
    public function query(): Builder
    {
        return Product::query()->with('subcategory');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Slug',
            'Descripción',
            'URL Imagen',
            'Precio',
            'Stock',
            'Estado',
            'Orden display',
            'ID Subcategoría',
        ];
    }

    /**
     * @param Product $product
     * @return array
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->slug,
            $product->description,
            $product->image,
            $product->price,
            $product->stock,
            $product->active,
            $product->order,
            $product->subcategory->name,
            $product->created_at,
            $product->updated_at,
        ];
    }
}
