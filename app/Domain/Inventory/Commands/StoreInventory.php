<?php

namespace App\Domain\Inventory\Commands;

use App\Domain\Inventory\Requests\StoreRequest;
use App\Domain\Inventory\Services\CreateOrUpdateInventory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:post-inventories
                            {--product_id= : The product id of the inventory}
                            {--warehouse_id= : The warehouse id of the inventory}
                            {--quantity= : The quantity of the inventory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new inventory via CLI';

    /**
     * Execute the console command.
     */
    public function handle(CreateOrUpdateInventory $createOrUpdateInventory)
    {
        // Get the input data from the command
        $data = [
            'product_id' => $this->option('product_id'),
            'warehouse_id' => $this->option('warehouse_id'),
            'quantity' => $this->option('quantity'),
        ];

        // Create a validator using the rules from StoreRequest
        $request = new StoreRequest();
        $validator = Validator::make($data, $request->rules());

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

        // Create the inventory with validated data
        $inventory = $createOrUpdateInventory->execute($validatedData);

        // Output success message
        $this->info("Inventory created successfully with ID: {$inventory->id}");

        return Command::SUCCESS;
    }
}
