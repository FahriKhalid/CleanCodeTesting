<?php

namespace Database\Factories;

use App\Domain\Order\Models\Order;
use App\Domain\Product\Models\Product;
use App\Domain\Inventory\Models\Inventory;
use App\Domain\Warehouse\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Create a product first so we can use it in both Order and Inventory
        $product = Product::factory()->create();

        // Create inventory for this product
        Inventory::factory()->create([
            'product_id' => $product->id,
            'warehouse_id' => Warehouse::factory(),
            'quantity' => $this->faker->numberBetween(10, 100), // Ensuring enough inventory
        ]);

        // Generate order quantity
        $quantity = $this->faker->numberBetween(1, 10);

        return [
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $product->price * $quantity, // Calculate total price based on product price and quantity
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
