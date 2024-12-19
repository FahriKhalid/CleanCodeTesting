<?php

namespace App\Domain\Product\Commands;

use App\Domain\Product\Models\Product;
use Illuminate\Console\Command;

class ListProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:index-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get list of products via CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Query the products based on the conditions
        $products = Product::get();

        // Prepare the data for the table
        $productData = $products->map(function ($product) {
            return [
                'ID' => $product->id,
                'Name' => $product->name,
                'Price' => $product->price,
                'Description' => $product->description,
            ];
        });

        // Display the data in a table format
        $this->table(
            ['ID', 'Name', 'Price', 'Description'],  // Header row
            $productData  // Data rows
        );
    }
}
