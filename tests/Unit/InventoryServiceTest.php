<?php

namespace Tests\Unit;

use App\Domain\Inventory\Exceptions\InsufficientStockException;
use App\Domain\Inventory\Models\Inventory;
use App\Domain\Inventory\Services\InventoryService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;

class InventoryServiceTest extends TestCase
{
    use DatabaseTransactions;

    private InventoryService $inventoryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inventoryService = new InventoryService();
    }

    public function test_update_product_inventory_deducts_quantity_correctly(): void
    {
        // Arrange
        $productId = 1;
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 50]);
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 30]);

        $quantityToDeduct = 60;

        // Act
        $this->inventoryService->updateProductInventory($productId, $quantityToDeduct);

        // Assert
        $this->assertEquals(20, Inventory::where('product_id', $productId)->sum('quantity'));
    }

    public function test_update_product_inventory_throws_exception_when_stock_is_insufficient(): void
    {
        // Arrange
        $productId = 2;
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 20]);

        $quantityToDeduct = 25;

        // Expect
        $this->expectException(InsufficientStockException::class);
        $this->expectExceptionMessage("Insufficient stock! Exist only:20 but required:25");

        // Act
        $this->inventoryService->updateProductInventory($productId, $quantityToDeduct);
    }

    public function test_update_product_inventory_handles_exact_quantity(): void
    {
        // Arrange
        $productId = 3;
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 40]);

        $quantityToDeduct = 40;

        // Act
        $this->inventoryService->updateProductInventory($productId, $quantityToDeduct);

        // Assert
        $this->assertEquals(0, Inventory::where('product_id', $productId)->sum('quantity'));
    }

    public function test_partial_update_distributes_across_multiple_inventories(): void
    {
        // Arrange
        $productId = 4;
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 10]);
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 20]);
        Inventory::factory()->create(['product_id' => $productId, 'quantity' => 30]);

        $quantityToDeduct = 45;

        // Act
        $this->inventoryService->updateProductInventory($productId, $quantityToDeduct);

        // Assert
        $this->assertEquals(15, Inventory::where('product_id', $productId)->sum('quantity'));
    }
}
