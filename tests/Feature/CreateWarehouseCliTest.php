<?php

namespace Tests\Feature;

use App\Domain\Warehouse\Models\Warehouse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;

class CreateWarehouseCliTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function test_cli_for_add_warehouse(): void
    {
        $payload = Warehouse::factory()->make()->toArray();

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:post-warehouses', [
            '--name' => $payload['name'],
        ]);

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the success message output from the CLI
        $this->assertStringContainsString('Warehouse created successfully with ID:', Artisan::output());

        // Assert that the database has the new inventory entry
        $this->assertDatabaseHas('warehouses', [
            'name' => $payload['name'],
        ]);
    }

    /**
     * Test for list an warehouse.
     */
    public function test_cli_for_list_warehouse(): void
    {
        // Create some sample warehouse data in the database
        $warehouse1 = Warehouse::factory()->create();

        $warehouse2 = Warehouse::factory()->create();

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:index-warehouses');

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the output contains the warehouse data we added
        $output = Artisan::output();

        // Check if the output contains the table headers and data for inventories
        $this->assertStringContainsString('ID', $output);
        $this->assertStringContainsString('Name', $output);

        // Check if specific warehouse items appear in the output
        $this->assertStringContainsString($warehouse1->id, $output);
        $this->assertStringContainsString($warehouse1->name, $output);

        $this->assertStringContainsString($warehouse2->id, $output);
        $this->assertStringContainsString($warehouse2->name, $output);
    }
}
