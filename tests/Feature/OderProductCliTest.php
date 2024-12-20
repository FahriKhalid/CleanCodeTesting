<?php

namespace Tests\Feature;

use App\Domain\Order\Events\GetProductDetail;
use App\Domain\Order\Models\Order;
use App\Domain\Product\Models\Product;
use App\Domain\Shared\Helpers\Terbilang;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use Tests\TestCase;

class OderProductCliTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function test_cli_for_order_product(): void
    {
        $payload = Order::factory()->make()->toArray();

        // Run the CLI command using Artisan::call()
        $exitCode = Artisan::call('api:post-orders', [
            '--product_id' => $payload['product_id'],
            '--quantity' => $payload['quantity'],
        ]);

        // Assert that the command was successful (exit code 0)
        $this->assertEquals(0, $exitCode);

        // Assert the success message output from the CLI
        $this->assertStringContainsString('Order has been processed', Artisan::output());

        // Assert that the database has the new inventory entry
        $this->assertDatabaseHas('orders', [
            'product_id' => $payload['product_id'],
            'quantity' => $payload['quantity'],
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_cli_for_print_invoice(): void
    {
        // Seed the database with test data
        $product = Product::factory()->create([
            'name' => 'jaket',
            'price' => 400000,
        ]);

        $order = Order::factory()->create([
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 800000,
        ]);

        // Mock the Terbilang helper class with argument
        $terbilangMock = Mockery::mock(Terbilang::class, [$order->total_price]);
        $terbilangMock->shouldReceive('toString')->andReturn('delapan ratus ribu');
        $this->app->instance(Terbilang::class, $terbilangMock);

        // Run the command
        $this->artisan('api:post-invoice --order_id=' . $order->id)
            ->expectsTable(
                ['Nama', 'Harga', 'Jumlah', 'Total Harga', 'Terbilang'],
                [
                    [
                        'Nama' => 'jaket',
                        'Harga' => 400000,
                        'Jumlah' => 2,
                        'Total Harga' => 800000,
                        'Terbilang' => 'delapan ratus ribu',
                    ],
                ]
            )
            ->assertExitCode(0); // SUCCESS code
    }
}
