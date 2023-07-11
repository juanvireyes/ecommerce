<?php

namespace App\Imports;

use App\Models\Product;
use App\Repositories\SubcategoryRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ProductsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithUpserts, WithChunkReading, ShouldQueue, WithEvents, SkipsEmptyRows
{
    use Importable;
    public function model(array $row): Model|null
    {
        HeadingRowFormatter::default('none');
        $subcategoryRepository = new SubcategoryRepository();
        $subcategory = $subcategoryRepository->getSubcategoryByName($row['Subcategoría']);
        Log::info('Subcategoría: ' . $subcategory);

        $subcategoryId = $subcategory->id;

        return new Product(
            [
                'name' => $row['Nombre'],
                'slug' => $row['Slug'],
                'description' => $row['Descripción'],
                'price' => $row['Precio'],
                'stock' => $row['Stock'],
                'active' => $row['Estado'],
                'order' => $row['Orden display'],
                'subcategory_id' => $subcategoryId
            ]
        );
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function uniqueBy(): string
    {
        return 'id';
    }

    public function registerEvents(): array
    {
        return [
            ImportFailed::class => function(ImportFailed $failed) {
                //
            },
        ];
    }
}
