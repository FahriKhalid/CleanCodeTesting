<?php

namespace App\Domain\Orders\Commands;

use App\Domain\Orders\Events\GetProductDetail;
use App\Domain\Orders\Models\Order;
use App\Domain\Shared\Helpers\Terbilang;
use Illuminate\Console\Command;

class InvoiceOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:post-invoice
                            {--order_id= : The product id of the inventory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get an invoice order via CLI';


    protected $terbilang;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order_id = $this->option('order_id');

        // Check if order_id is provided
        if (!$order_id) {
            $this->error('The --order_id option is required.');
            return Command::FAILURE; // Exit with failure code
        }

        try {
            // Step 1: Get detail order by order id
            $order = Order::findOrFail($order_id);

            // Step 2: Get product detail via Domain Event
            $productDetail = event(new GetProductDetail($order['product_id']))[0];

            // Step 3: initialize Terbilang class for convert total price to string
            $terbilang = new Terbilang($order->total_price);

            // Step 4: Display the data in a table format
            $this->table(
                ['Nama', 'Harga', 'Jumlah', 'Total Harga', 'Terbilang'],  // Header row
                [
                    [
                        'Nama' => $productDetail['name'],
                        'Harga' => $productDetail['price'],
                        'Jumlah' => $order->quantity,
                        'Total Harga' => $order->total_price,
                        'Terbilang' => $terbilang->toString()
                    ]
                ]
            );

            return Command::SUCCESS; // Exit with success code
        } catch (\Throwable $th) {
            $this->info($th->getMessage());
            return Command::FAILURE; // Exit with failure code
        }
    }
}
