<?php

namespace App\Domain\Order\Services;

use App\Domain\Order\DTO\OrderData;
use App\Domain\Order\Events\GetProductDetail;
use App\Domain\Order\Events\OrderProcessed;
use App\Domain\Order\Models\Order;

class OrderProduct
{
    protected $createOrder;

    public function __construct(CreateOrder $createOrder)
    {
        $this->createOrder = $createOrder;
    }

    public function execute(OrderData $data): Order
    {
        // Step 1: Get product detail via Domain Event
        $productDetail = event(new GetProductDetail($data->product_id))[0];

        // Step 2: Create new order
        $ordered = $this->createOrder->execute($data, $productDetail);

        // Step 3: Run event to process ordering
        event(new OrderProcessed($ordered));

        return $ordered;
    }
}
