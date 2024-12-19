<?php

namespace App\Domain\Warehouse\Commands;

use App\Domain\Warehouse\Models\Warehouse;
use Illuminate\Console\Command;

class ListWarehouse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:index-warehouses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get list of warehouses via CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Query the warehouses based on the conditions
        $warehouses = Warehouse::get();

        // Prepare the data for the table
        $warehouseData = $warehouses->map(function ($warehouse) {
            return [
                'ID' => $warehouse->id,
                'Name' => $warehouse->name,
            ];
        });

        // Display the data in a table format
        $this->table(
            ['ID', 'Name'],  // Header row
            $warehouseData  // Data rows
        );
    }
}
