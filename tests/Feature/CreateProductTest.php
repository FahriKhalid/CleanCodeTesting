<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Domain\Product\Models\Product;

class CreateProductTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for adding a product.
     */
    public function test_for_add_product(): void
    {
        // Generate test data using the factory
        $payload = Product::factory()->make()->toArray();

        // Send POST request and validate the response
        $response = $this->json('POST', 'api/product', $payload);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $payload['name'],
                'price' => $payload['price'],
                'description' => $payload['description']
            ]);

        // Verify the database contains the record
        $this->assertDatabaseHas('products', [
            'name' => $payload['name'],
            'price' => $payload['price'],
            'description' => $payload['description']
        ]);
    }
}
