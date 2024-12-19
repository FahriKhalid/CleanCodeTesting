<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\Models\Product;
use App\Domain\Product\DTO\ProductData;
use Illuminate\Support\Facades\Request;

class CreateProduct
{
    public function execute(ProductData $data): Product
    {

        $new = new Product();
        $new->name  = $data->name;
        $new->description = $data->description;
        $new->price = $data->price;
        $new->save();

        return $new;
    }
}
