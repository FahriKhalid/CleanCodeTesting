<?php

namespace App\Domain\Order\DTO;

use App\Domain\Shared\Traits\FormRequestTrait;

class OrderData
{
    use FormRequestTrait;

    public int $product_id;
    public float $quantity;

    // Modify the constructor to use default values
    public function __construct(
        int $product_id = 0,
        float $quantity = 0
    ) {
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }
}
