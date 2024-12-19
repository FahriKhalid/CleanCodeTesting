<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\Inventory;

class UpdateInventoryQuantity
{
    public function execute(Inventory $inventory, int $quantity): Inventory
    {
        $inventory->quantity += $quantity;
        $inventory->save();

        return $inventory;
    }
}
