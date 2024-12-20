<?php

namespace Tests\Feature;

use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CreateProductCliTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_cli_for_add_product(): void
    {
        $payload = Product::factory()->make()->toArray();

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:post-products', [
            '--name' => $payload['name'],
            '--price' => $payload['price'],
            '--description' => $payload['description'],
        ]);

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the success message output from the CLI
        $this->assertStringContainsString('Product created successfully with ID:', Artisan::output());

        // Assert that the database has the new product entry
        $this->assertDatabaseHas('products', [
            'name' => $payload['name'],
            'price' => $payload['price'],
            'description' => $payload['description'],
        ]);
    }

    /**
     * Test for list an product.
     */
    public function test_cli_for_list_product(): void
    {
        // Create some sample product data in the database
        $product1 = Product::factory()->create();

        $product2 = Product::factory()->create();

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:index-products');

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the output contains the product data we added
        $output = Artisan::output();

        // Check if the output contains the table headers and data for inventories
        $this->assertStringContainsString('ID', $output);
        $this->assertStringContainsString('Name', $output);
        $this->assertStringContainsString('Price', $output);
        $this->assertStringContainsString('Description', $output);

        // Check if specific product items appear in the output
        $this->assertStringContainsString($product1->id, $output);
        $this->assertStringContainsString($product1->name, $output);
        $this->assertStringContainsString($product1->price, $output);
        $this->assertStringContainsString($product1->description, $output);

        $this->assertStringContainsString($product2->id, $output);
        $this->assertStringContainsString($product2->name, $output);
        $this->assertStringContainsString($product2->price, $output);
        $this->assertStringContainsString($product2->description, $output);
    }
}
