<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Domain\Product\Commands\StroreProduct::class,
        \App\Domain\Product\Commands\ListProduct::class,
        \App\Domain\Warehouse\Commands\StoreWarehouse::class,
        \App\Domain\Warehouse\Commands\ListWarehouse::class,
        \App\Domain\Inventory\Commands\StoreInventory::class,
        \App\Domain\Inventory\Commands\ListInventory::class,
        \App\Domain\Order\Commands\CreateOrder::class,
        \App\Domain\Order\Commands\InvoiceOrder::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
