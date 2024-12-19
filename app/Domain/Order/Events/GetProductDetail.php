<?php

namespace App\Domain\Order\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GetProductDetail
{
    use Dispatchable, SerializesModels;

    public $productId;

    /**
     * Create a new event instance.
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }
}
