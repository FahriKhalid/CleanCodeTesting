<?php

namespace App\Providers;

use App\Domain\Inventory\Listeners\UpdateInventoryQuantity;
use App\Domain\Order\Events\GetProductDetail;
use App\Domain\Order\Events\OrderProcessed;
use App\Domain\Product\Listeners\GetProductDetailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        GetProductDetail::class => [
            GetProductDetailListener::class,
        ],

        OrderProcessed::class => [
            UpdateInventoryQuantity::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
