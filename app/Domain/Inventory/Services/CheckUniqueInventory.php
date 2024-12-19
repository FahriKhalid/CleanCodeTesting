<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\Inventory;

class CheckUniqueInventory
{
    public function execute(int $product_id, int $warehouse_id): ?Inventory
    {
        return Inventory::productId($product_id)
            ->warehouseId($warehouse_id)
            ->first();
    }
}
