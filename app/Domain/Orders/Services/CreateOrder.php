<?php

namespace App\Domain\Orders\Services;

use App\Domain\Orders\Models\Order;
use App\Domain\Product\Models\Product;

class CreateOrder
{
    public function execute(array $data, array $product): Order
    {
        $totalPrice = $product['price'] * $data['quantity'];

        $newOrder = new Order();
        $newOrder->product_id = $data['product_id'];
        $newOrder->quantity = $data['quantity'];
        $newOrder->total_price = $totalPrice;
        $newOrder->save();

        return $newOrder;
    }
}
