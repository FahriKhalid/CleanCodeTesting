<?php

namespace App\Domain\Order\Commands;

use App\Domain\Order\DTO\OrderData;
use App\Domain\Order\Requests\StoreRequest;
use App\Domain\Order\Services\OrderProduct;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:post-orders
                            {--product_id= : The product id of the inventory}
                            {--quantity= : The warehouse id of the inventory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new inventory via CLI';

    /**
     * Execute the console command.
     */
    public function handle(OrderProduct $orderProduct)
    {
        // Get the input data from the command
        $data = new OrderData(
            product_id: $this->option('product_id'),
            quantity: $this->option('quantity'),
        );

        // Create the inventory with validated data
        $orderProduct->execute($data);

        // Output success message
        $this->info('Order has been processed');

        return Command::SUCCESS; // Exit with success code
    }
}
