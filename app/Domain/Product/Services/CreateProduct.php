<?php

namespace App\Domain\Product\Services;

use App\Domain\Product\Models\Product;
use Illuminate\Support\Facades\Request;

class CreateProduct
{
    public function execute(array $data): Product
    {
        $new = new Product();
        $new->name  = $data['name'];
        $new->description = $data['description'];
        $new->price = $data['price'];
        $new->save();

        return $new;
    }
}
