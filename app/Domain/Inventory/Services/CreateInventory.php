<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\Inventory;

class CreateInventory
{
    public function execute(array $data): Inventory
    {
        $newInventory = new Inventory();
        $newInventory->product_id = $data['product_id'];
        $newInventory->warehouse_id = $data['warehouse_id'];
        $newInventory->quantity = $data['quantity'];
        $newInventory->save();

        return $newInventory;
    }
}
