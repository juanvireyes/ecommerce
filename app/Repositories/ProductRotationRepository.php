<?php

namespace App\Repositories;

use App\Models\ProductRotationReport;
use App\Repositories\Contracts\ProductRotationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRotationRepository implements ProductRotationRepositoryInterface
{
    public function getAllRegisters(string $column, string $direction): LengthAwarePaginator
    {
        return ProductRotationReport::query()
            ->with('products')
            ->orderBy($column, $direction)
            ->paginate(20);
    }

    public function getRegisterById(int $id): ProductRotationReport
    {
        return ProductRotationReport::findOrFail($id);
    }

    public function getRegisterByProductId (int $productId): ?ProductRotationReport
    {
        return ProductRotationReport::where('product_id', $productId)->first();
    }

    public function createRegister(int $productId, int $soldUnits): ProductRotationReport
    {
        return ProductRotationReport::create([
            'product_id' => $productId,
            'sold_units' => $soldUnits
        ]);
    }

    public function updateRegister(ProductRotationReport $register, array $data): ProductRotationReport
    {
        $register->update($data);
        return $register;
    }
}
