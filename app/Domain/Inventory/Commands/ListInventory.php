<?php

namespace App\Domain\Inventory\Commands;

use App\Domain\Inventory\Models\Inventory;
use Illuminate\Console\Command;

class ListInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:index-inventories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get inventory via CLI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Query the inventories based on the conditions
        $inventories = Inventory::get();

        // Prepare the data for the table
        $inventoryData = $inventories->map(function ($inventory) {
            return [
                'ID' => $inventory->id,
                'Product ID' => $inventory->product_id,
                'Warehouse ID' => $inventory->warehouse_id,
                'Quantity' => $inventory->quantity,
            ];
        });

        // Display the data in a table format
        $this->table(
            ['ID', 'Product ID', 'Warehouse ID', 'Quantity'],  // Header row
            $inventoryData  // Data rows
        );
    }
}
