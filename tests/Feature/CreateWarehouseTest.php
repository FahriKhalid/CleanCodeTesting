<?php

namespace Tests\Feature;

use App\Domain\Warehouse\Models\Warehouse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateWarehouseTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_for_add_warehouse(): void
    {
        // Generate test data using the factory
        $payload = Warehouse::factory()->make()->toArray();

        // Send POST request and validate the response
        $response = $this->json('POST', 'api/warehouse', $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $payload['name']
            ]);

        // Verify the database contains the record
        $this->assertDatabaseHas('warehouses', [
            'name' => $payload['name']
        ]);
    }
}
