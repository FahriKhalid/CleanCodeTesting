<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Domain\Product\Services\CreateProduct;
use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_product_successfully()
    {
        // Arrange: Prepare test data
        $data = [
            'name' => 'Test Product',
            'category_id' => 1,
            'description' => 'This is a test product description',
            'price' => 99.99,
        ];

        // Act: Execute the service
        $createProductService = new CreateProduct();
        $product = $createProductService->execute($data);

        // Assert: Verify the product is created correctly
        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'category_id' => 1,
            'description' => 'This is a test product description',
            'price' => 99.99,
        ]);
    }
}
