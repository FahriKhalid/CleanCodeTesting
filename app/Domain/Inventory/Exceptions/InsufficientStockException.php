<?php

namespace App\Domain\Inventory\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public function __construct(int $required, int $available)
    {
        $message = "Insufficient stock! Exist only:$available but required: $required";
        parent::__construct($message);
    }
}
