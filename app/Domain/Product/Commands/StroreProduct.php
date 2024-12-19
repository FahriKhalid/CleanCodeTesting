<?php

namespace App\Domain\Product\Commands;

use App\Domain\Product\DTO\ProductData;
use App\Domain\Product\Requests\StoreRequest;
use App\Domain\Product\Services\CreateProduct;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StroreProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:post-products
                            {--name= : The name of the product}
                            {--price= : The price of the product}
                            {--description= : The description of the product (optional)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product via CLI';

    /**
     * Execute the console command.
     */
    public function handle(CreateProduct $createProduct)
    {
        // Get the input data from the command
        $data = new ProductData(
            name: $this->option('name'),
            price: $this->option('price'),
            description: $this->option('description')
        );

        // Create a validator using the rules from StoreRequest
        $request = new StoreRequest();
        $validator = Validator::make(collect($data)->toArray(), $request->rules());

        try {
            // Validate the data
            $validatedData = $validator->validate();
        } catch (ValidationException $e) {
            // If validation fails, output the errors
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);  // Print each validation error
            }
            return Command::FAILURE;
        }

        // Create the product with validated data
        $product = $createProduct->execute($data);

        // Output success message
        $this->info("Product created successfully with ID: {$product->id}");

        return Command::SUCCESS;
    }
}
