<?php

namespace Tests\Unit;

use App\Domain\Inventory\Models\Inventory;
use App\Domain\Inventory\Services\CheckUniqueInventory;
use App\Domain\Inventory\Services\CreateInventory;
use App\Domain\Inventory\Services\CreateOrUpdateInventory;
use App\Domain\Inventory\Services\UpdateInventoryQuantity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Tests\TestCase;

class CreateOrUpdateInventoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $checkUniqueInventoryMock;
    protected $updateInventoryQuantityMock;
    protected $createInventoryMock;
    protected $createOrUpdateInventoryService;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var CheckUniqueInventory&\Mockery\MockInterface */
        $this->checkUniqueInventoryMock = Mockery::mock(CheckUniqueInventory::class);

        /** @var UpdateInventoryQuantity&\Mockery\MockInterface */
        $this->updateInventoryQuantityMock = Mockery::mock(UpdateInventoryQuantity::class);

        /** @var CreateInventory&\Mockery\MockInterface */
        $this->createInventoryMock = Mockery::mock(CreateInventory::class);

        $this->createOrUpdateInventoryService = new CreateOrUpdateInventory(
            $this->checkUniqueInventoryMock,
            $this->updateInventoryQuantityMock,
            $this->createInventoryMock
        );
    }

    public function test_execute_updates_existing_inventory(): void
    {
        // Arrange
        $data = [
            'product_id' => 1,
            'warehouse_id' => 1,
            'quantity' => 50,
        ];

        $existingInventory = Inventory::factory()->make(['product_id' => 1, 'warehouse_id' => 1, 'quantity' => 100]);

        $this->checkUniqueInventoryMock
            ->shouldReceive('execute')
            ->once()
            ->with(1, 1)
            ->andReturn($existingInventory);

        $this->updateInventoryQuantityMock
            ->shouldReceive('execute')
            ->once()
            ->with($existingInventory, 50)
            ->andReturn($existingInventory);

        // Act
        $result = $this->createOrUpdateInventoryService->execute($data);

        // Assert
        $this->assertSame($existingInventory, $result);
    }

    public function test_execute_creates_new_inventory(): void
    {
        // Arrange
        $data = [
            'product_id' => 2,
            'warehouse_id' => 1,
            'quantity' => 20,
        ];

        $newInventory = Inventory::factory()->make($data);

        $this->checkUniqueInventoryMock
            ->shouldReceive('execute')
            ->once()
            ->with(2, 1)
            ->andReturn(null);

        $this->createInventoryMock
            ->shouldReceive('execute')
            ->once()
            ->with($data)
            ->andReturn($newInventory);

        // Act
        $result = $this->createOrUpdateInventoryService->execute($data);

        // Assert
        $this->assertSame($newInventory, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
