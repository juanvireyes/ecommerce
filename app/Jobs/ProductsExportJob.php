<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProductsExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; 

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

        $timeZone = date_default_timezone_get();
        Log::info('Timezone: ' . $timeZone);

        $fileName = 'exports/products-' . date('Ymd-His') . '.xlsx';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($headers, 'A1');
        $row = 2;

        Product::chunk(10, function ($products) use ($sheet, &$row) {
            foreach ($products as $product) {
                $sheet->setCellValue('A' . $row, $product->name);
                $sheet->setCellValue('B' . $row, $product->slug);
                $sheet->setCellValue('C' . $row, $product->description);
                $sheet->setCellValue('D' . $row, $product->image);
                $sheet->setCellValue('E' . $row, $product->price);
                $sheet->setCellValue('F' . $row, $product->stock);
                $sheet->setCellValue('G' . $row, $product->active);
                $sheet->setCellValue('H' . $row, $product->subcategory->name);
                $sheet->setCellValue('I' . $row, $product->subcategory->category->name);

                $row++;
            }
        });

        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/' . $fileName));
    }
}
