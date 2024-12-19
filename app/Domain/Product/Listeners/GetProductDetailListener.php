<?php

namespace App\Domain\Product\Listeners;

use App\Domain\Orders\Events\GetProductDetail;
use App\Domain\Product\Models\Product;

class GetProductDetailListener
{
    public function handle(GetProductDetail $event): array
    {
        $product = Product::find($event->productId);

        if (!$product) {
            return [];
        }

        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
        ];
    }
}
