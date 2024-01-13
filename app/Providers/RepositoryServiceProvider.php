<?php

namespace App\Providers;

use App\Repositories\Shipment\ShipmentHeader\ShipmentHeaderRepository;
use App\Repositories\Shipment\ShipmentHeader\ShipmentHeaderRepositoryInterface;
use App\Repositories\Shipment\ShipmentRepository;
use App\Repositories\Shipment\ShipmentRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ShipmentHeaderRepositoryInterface::class,
            ShipmentHeaderRepository::class
        );

        $this->app->bind(
            ShipmentRepositoryInterface::class,
            ShipmentRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
