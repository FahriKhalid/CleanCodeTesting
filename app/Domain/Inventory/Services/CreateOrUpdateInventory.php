<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Models\Inventory;

class CreateOrUpdateInventory
{
    protected $checkUniqueInventory;

    protected $updateInventoryQuantity;

    protected $createInventory;

    public function __construct(
        CheckUniqueInventory $checkUniqueInventory,
        UpdateInventoryQuantity $updateInventoryQuantity,
        CreateInventory $createInventory
    ) {
        $this->checkUniqueInventory = $checkUniqueInventory;
        $this->updateInventoryQuantity = $updateInventoryQuantity;
        $this->createInventory = $createInventory;
    }

    public function execute(array $data): Inventory
    {
        // Step 1: Check if inventory with the same product_id and warehouse_id exists
        $existingInventory = $this->checkUniqueInventory->execute($data['product_id'], $data['warehouse_id']);

        if ($existingInventory) {
            // Step 2: If it exists, update the quantity
            return $this->updateInventoryQuantity->execute($existingInventory, $data['quantity']);
        }

        // Step 3: If it doesn't exist, create a new inventory record
        return $this->createInventory->execute($data);
    }
}
