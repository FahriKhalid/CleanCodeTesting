<?php

namespace App\Domain\Product\DTO;

use App\Domain\Shared\Traits\FormRequestTrait;

class ProductData
{
    use FormRequestTrait;

    public string $name;

    public ?string $description;

    public float $price;

    // Modify the constructor to use default values
    public function __construct(
        string $name = '',
        ?string $description = null,
        float $price = 0.0
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}
