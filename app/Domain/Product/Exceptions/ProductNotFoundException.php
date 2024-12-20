<?php

// app/Exceptions/ProductNotFoundException.php
namespace App\Domain\Product\Exceptions;

use Exception;

class ProductNotFoundException extends Exception
{
    protected $message = 'Product not found.';
}
