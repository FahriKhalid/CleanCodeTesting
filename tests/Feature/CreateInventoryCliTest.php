<?php

namespace Tests\Feature;

use App\Domain\Inventory\Models\Inventory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CreateInventoryCliTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test for adding an inventory.
     */
    public function test_cli_for_add_inventory(): void
    {
        $payload = Inventory::factory()->make()->toArray();

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:post-inventories', [
            '--product_id' => $payload['product_id'],
            '--warehouse_id' => $payload['warehouse_id'],
            '--quantity' => $payload['quantity'],
        ]);

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the success message output from the CLI
        $this->assertStringContainsString('Inventory created successfully with ID:', Artisan::output());

        // Assert that the database has the new inventory entry
        $this->assertDatabaseHas('inventories', [
            'product_id' => $payload['product_id'],
            'warehouse_id' => $payload['warehouse_id'],
            'quantity' => $payload['quantity'],
        ]);
    }

    /**
     * Test for list an inventory.
     */
    public function test_cli_for_list_inventory(): void
    {
        // Create some sample inventory data in the database
        Inventory::factory()->create([
            'product_id' => 1,
            'warehouse_id' => 1,
            'quantity' => 100,
        ]);

        Inventory::factory()->create([
            'product_id' => 2,
            'warehouse_id' => 1,
            'quantity' => 200,
        ]);

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:index-inventories');

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the output contains the inventory data we added
        $output = Artisan::output();

        // Check if the output contains the table headers and data for inventories
        $this->assertStringContainsString('ID', $output);
        $this->assertStringContainsString('Product ID', $output);
        $this->assertStringContainsString('Warehouse ID', $output);
        $this->assertStringContainsString('Quantity', $output);

        // Check if specific inventory items appear in the output
        $this->assertStringContainsString('1', $output); // Check if the product_id of the first inventory is listed
        $this->assertStringContainsString('100', $output); // Check if the quantity of the first inventory is listed
        $this->assertStringContainsString('2', $output); // Check if the product_id of the second inventory is listed
        $this->assertStringContainsString('200', $output); // Check if the quantity of the second inventory is listed
    }
}
