<?php

namespace App\Actions;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductRotationReport;
use App\Repositories\ProductRotationRepository;

class CreateProductReportRegisterAction
{
    public function __construct(
        private readonly Order            $order,
        public ProductRotationRepository $productRotationRepository,
        public ProductRotationReport     $register
    )
    {}
    public function execute(): void
    {
        $orderItems = OrderDetail::where('order_id', $this->order->id)->get();

        foreach ($orderItems as $product) {
            $productId = $product->product_id;
            $soldUnits = $product->quantity;

            $productRegister = $this->productRotationRepository->getRegisterByProductId($productId);

            if ($productRegister) {
                $productRegister->increaseSoldUnits($soldUnits);
            } else {
                $this->productRotationRepository->createRegister($productId, $soldUnits);
            }
        };
    }
}
