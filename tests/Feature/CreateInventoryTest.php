<?php

namespace Tests\Feature;

use App\Domain\Inventory\Models\Inventory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateInventoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for adding a product.
     */
    public function test_for_add_inventory(): void
    {
        $payload = Inventory::factory()->make()->toArray();

        // Send POST request and validate the response
        $response = $this->json('POST', 'api/inventory', $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'quantity' => $payload['quantity'],
                'product_id' => $payload['product_id'],
                'warehouse_id' => $payload['warehouse_id'],
            ]);

        // Verify the database contains the record
        $this->assertDatabaseHas('inventories', [
            'quantity' => $payload['quantity'],
            'product_id' => $payload['product_id'],
            'warehouse_id' => $payload['warehouse_id'],
        ]);
    }
}
