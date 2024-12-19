<?php

namespace App\Domain\Inventory\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(int $productId, int $required, int $available)
    {
        $message = "Not enough stock to fulfill the order for product ID: $productId. Required: $required, Available: $available.";
        parent::__construct($message);
    }
}
