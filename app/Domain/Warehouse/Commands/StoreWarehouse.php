<?php

namespace App\Domain\Warehouse\Commands;

use App\Domain\Warehouse\Requests\StoreRequest;
use App\Domain\Warehouse\Services\CreateWarehouse;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StoreWarehouse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:post-warehouses
                            {--name= : The name of the product}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new warehouse via CLI';

    /**
     * Execute the console command.
     */
    public function handle(CreateWarehouse $createWarehouse)
    {
        // Get the input data from the command
        $data = [
            'name' => $this->option('name'),
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

        // Create the warehouse with validated data
        $warehouse = $createWarehouse->execute($validatedData);

        // Output success message
        $this->info("Warehouse created successfully with ID: {$warehouse->id}");

        return Command::SUCCESS;
    }
}
