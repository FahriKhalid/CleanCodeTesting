<?php

namespace App\Domain\Inventory\Listeners;

use App\Domain\Inventory\Models\Inventory;
use App\Domain\Inventory\Services\InventoryService;
use App\Domain\Order\Events\OrderProcessed;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateInventoryQuantity implements ShouldQueue
{
    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function handle(OrderProcessed $event): void
    {
        try {
            $productId = $event->data['product_id'];
            $quantityToDeduct = $event->data['quantity'];

            // Delegate inventory update to the service
            $this->inventoryService->updateProductInventory($productId, $quantityToDeduct);
        } catch (\Throwable $th) {
            Log::error('Failed to update inventory quantity.', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
            throw $th; // Re-throw the exception for proper handling
        }
    }
}
