<?php

namespace App\Domain\Order\Services;

use App\Domain\Order\DTO\OrderData;
use App\Domain\Order\Models\Order;
use App\Domain\Product\Models\Product;

class CreateOrder
{
    public function execute(OrderData $data, Product $product): Order
    {
        $totalPrice = $product['price'] * $data->quantity;

        $newOrder = new Order();
        $newOrder->product_id = $data->product_id;
        $newOrder->quantity = $data->quantity;
        $newOrder->total_price = $totalPrice;
        $newOrder->save();

        return $newOrder;
    }
}
