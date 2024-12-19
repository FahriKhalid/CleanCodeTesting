<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\Inventory;

class CheckUniqueInventory
{
    public function execute(int $productId, int $warehouseId): ?Inventory
    {
        return Inventory::productId($productId)
            ->warehouseId($warehouseId)
            ->first();
    }
}
