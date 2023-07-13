<?php

namespace App\Repositories\Contracts;

use App\Models\ProductRotationReport;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRotationRepositoryInterface
{
    public function getAllRegisters(string $column, string $direction): LengthAwarePaginator;

    public function getRegisterById(int $id): ProductRotationReport;

    public function createRegister(int $productId, int $soldUnits): ProductRotationReport;

    public function updateRegister(ProductRotationReport $register, array $data): ProductRotationReport;
}
