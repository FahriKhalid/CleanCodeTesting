<?php

namespace Tests\Unit;

use App\Domain\Product\DTO\ProductData;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Services\CreateProduct;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_creates_a_product_successfully()
    {
        $payload = Product::factory()->make();

        // Arrange: Prepare test data
        $data = new ProductData(
            name: $payload->name,
            description: $payload->description,
            price: $payload->price,
        );

        // Act: Execute the service
        $createProductService = new CreateProduct();
        $product = $createProductService->execute($data);

        // Assert: Verify the product is created correctly
        $this->assertInstanceOf(Product::class, $product);
        $this->assertDatabaseHas('products', [
            'name' => $payload->name,
            'description' => $payload->description,
            'price' => $payload->price,
        ]);
    }
}
