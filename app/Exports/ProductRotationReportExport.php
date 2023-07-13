<?php

namespace App\Exports;

use App\Models\ProductRotationReport;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductRotationReportExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public string $column;
    public string $order;

    public function __construct(string $column, string $order)
    {
        $this->column = $column;
        $this->order = $order;

    }
    public function query(): Builder
    {
        return ProductRotationReport::query()
            ->with('products')
            ->orderBy($this->column, $this->order);
    }

    public function headings(): array
    {
        return [
            'Id registro',
            'Nombre producto',
            'Descripción',
            'Precio',
            'Estado',
            'Total unidades vendidas'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->product_id,
            $row->products->name,
            $row->products->description,
            $row->products->price,
            $row->products->active,
            $row->sold_units
        ];
    }
}
