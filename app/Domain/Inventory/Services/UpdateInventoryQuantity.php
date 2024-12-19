<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\Inventory;

class UpdateInventoryQuantity
{
    public function execute(Inventory $inventory, int $quantity, string $operation = '+='): Inventory
    {
        // Adjust the quantity as needed
        $inventory->quantity += $quantity;  // Or other logic for quantity adjustment
        $inventory->save();

        return $inventory;
    }
}
