<?php

namespace Tests\Unit;

use App\Domain\Inventory\Models\Inventory;
use App\Domain\Inventory\Services\UpdateInventoryQuantity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Tests\TestCase;


class UpdateInventoryQuantityTest extends TestCase
{
    use DatabaseTransactions;

    protected $updateInventoryQuantityService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->updateInventoryQuantityService = new UpdateInventoryQuantity();
    }

    public function test_execute_updates_inventory_quantity(): void
    {
        // Arrange: Create a mock inventory record
        $inventory = Inventory::factory()->create([
            'product_id' => 1,
            'warehouse_id' => 1,
            'quantity' => 100,
        ]);

        // Act: Update inventory quantity
        $result = $this->updateInventoryQuantityService->execute($inventory, 50);

        // Assert: The quantity should be updated
        $this->assertEquals(150, $result->quantity);
        $this->assertTrue($result->wasChanged());
    }
}
