<?php

namespace Tests\Unit;

use App\Domain\Warehouse\Models\Warehouse;
use App\Domain\Warehouse\Services\CreateWarehouse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateWarehouseTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic unit test example.
     */
    public function test_it_creates_a_warehouse_successfully()
    {
        // Arrange: Prepare test data
        $data = [
            'name' => 'Test Warehouse',
        ];

        // Act: Execute the service
        $createProductService = new CreateWarehouse();
        $product = $createProductService->execute($data);

        // Assert: Verify the product is created correctly
        $this->assertInstanceOf(Warehouse::class, $product);
        $this->assertDatabaseHas('warehouses', [
            'name' => 'Test Warehouse',
        ]);
    }
}
