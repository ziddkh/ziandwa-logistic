<?php

namespace App\Console\Commands;

use App\Models\Shipment\ShipmentHeader;
use Illuminate\Console\Command;

class ChangePriceDestination extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:price-destination';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change price destination for shipment header with destination for surabaya swasta';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $shipmentHeaders = ShipmentHeader::with(['shipmentItems'])->withTrashed()->where('destination_id', 4)->get();
        foreach ($shipmentHeaders as $shipmentHeader) {
            $shipmentHeader->update([
                'destination_cost' => 1500000,
            ]);
            $this->info('Shipment header with shipment number '.$shipmentHeader->shipment_number.' has been updated');
        }

        $this->info('All price destination for shipment header with destination surabaya swasta has been updated');
    }
}
