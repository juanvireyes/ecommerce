<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductsExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        $headers = [
            'Nombre producto',
            'Slug',
            'Descripcion',
            'Url imagen',
            'Precio',
            'Stock',
            'Estado',
            'Subcategoria',
            'Categoría'             
        ];

        $fileName = 'exports/products-' . date('Ymd') . '.xlsx';
        Product::chunk(10, function ($products) {
            
        });
    }
}
