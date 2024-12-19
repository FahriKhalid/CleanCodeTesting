<?php

namespace App\Domain\Inventory\Services;

use App\Domain\Inventory\Exceptions\InsufficientStockException;
use App\Domain\Inventory\Models\Inventory;
use Illuminate\Support\Facades\Log;

class InventoryService
{
    public function updateProductInventory(int $productId, int $quantityToDeduct): void
    {
        // Step 1: Calculate total available stock for the product
        $totalAvailableQuantity = $this->getTotalAvailableQuantity($productId);

        if ($quantityToDeduct > $totalAvailableQuantity) {
            $this->handleInsufficientStock($productId, $quantityToDeduct, $totalAvailableQuantity);
        }

        // Step 2: Deduct quantity across warehouses
        $this->deductFromWarehouses($productId, $quantityToDeduct);
    }

    protected function getTotalAvailableQuantity(int $productId): int
    {
        return Inventory::where('product_id', $productId)->sum('quantity');
    }

    protected function handleInsufficientStock(int $productId, int $required, int $available): void
    {
        Log::warning('Insufficient stock for product order.', [
            'product_id' => $productId,
            'required_quantity' => $required,
            'available_quantity' => $available,
        ]);

        throw new InsufficientStockException($productId, $required, $available);
    }

    protected function deductFromWarehouses(int $productId, int $quantityToDeduct): void
    {
        $warehouses = Inventory::where('product_id', $productId)
            ->where('quantity', '>', 0)
            ->get();

        foreach ($warehouses as $warehouse) {
            if ($quantityToDeduct <= 0) {
                break; // Stop once the order quantity is fulfilled
            }

            $availableQuantity = $warehouse->quantity;

            if ($availableQuantity >= $quantityToDeduct) {
                $warehouse->quantity -= $quantityToDeduct;
                $warehouse->save();
                $quantityToDeduct = 0; // All required quantity is deducted
            } else {
                $quantityToDeduct -= $availableQuantity;
                $warehouse->quantity = 0;
                $warehouse->save();
            }
        }
    }
}
