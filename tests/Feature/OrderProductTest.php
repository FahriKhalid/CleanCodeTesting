<?php

namespace Tests\Feature;

use App\Domain\Order\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test for oder product.
     */
    public function test_for_order_product(): void
    {
        // Generate test data using the factory
        $payload = Order::factory()->make()->toArray();

        // Send POST request and validate the response
        $response = $this->json('POST', 'api/order', $payload);

        $response->assertStatus(200)
            ->assertJsonFragment($payload);

        // Verify the database contains the record
        $this->assertDatabaseHas('orders', $payload);
    }
}
