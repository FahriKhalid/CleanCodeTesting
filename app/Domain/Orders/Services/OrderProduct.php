<?php

namespace App\Domain\Orders\Services;

use App\Domain\Orders\Events\GetDetailProduct;
use App\Domain\Orders\Events\GetProductDetail;
use App\Domain\Orders\Events\OrderProcessed;
use App\Domain\Orders\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderProduct
{
    protected $createOrder;

    public function __construct(CreateOrder $createOrder)
    {
        $this->createOrder = $createOrder;
    }

    public function execute(array $data): Order
    {
        // Step 1: Get product detail via Domain Event
        $productDetail = event(new GetProductDetail($data['product_id']))[0];

        // Step 2: Create new order
        $ordered = $this->createOrder->execute($data, $productDetail);

        // Step 3: Run event to process ordering
        event(new OrderProcessed($ordered));

        return $ordered;
    }
}
