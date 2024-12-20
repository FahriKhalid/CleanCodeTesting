<?php

namespace App\Domain\Product\Listeners;

use App\Domain\Order\Events\GetProductDetail;
use App\Domain\Product\Exceptions\ProductNotFoundException;
use App\Domain\Product\Models\Product;
use Exception;

class GetProductDetailListener
{
    public function handle(GetProductDetail $event): Product
    {
        // Assuming you're fetching the product from the database
        $product = Product::find($event->productId);

        if (! $product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }
}
