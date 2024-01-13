<?php

namespace App\Console\Commands;

use App\Models\Shipment\ShipmentHeader;
use Illuminate\Console\Command;

class GenerateHarborName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:harbor-name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate harbor name for shipment header';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $shipmentHeaders = ShipmentHeader::with(['shipmentItems'])->withTrashed()->get();
        foreach ($shipmentHeaders as $shipmentHeader) {
            $shipName = $shipmentHeader->shipmentItems->first()->ship_name ?? '';
            $shipName = strtolower($shipName);
            $harborName = '';
            if (! $shipName) {
                $this->info('Ship name for shipment header with id '.$shipmentHeader->shipment_number.' is empty');

                continue;
            }
            if ($shipName == 'bacan' || $shipName == 'labuha') {
                $harborName = 'KUPAL';
                $this->info('Ship name for shipment header with code '.$shipmentHeader->shipment_number.' is '.$shipName.' so harbor name is '.$harborName);
            } elseif ($shipName == 'babang') {
                $harborName = 'BABANG';
                $this->info('Ship name for shipment header with code '.$shipmentHeader->shipment_number.' is '.$shipName.' so harbor name is '.$harborName);
            } elseif ($shipName == 'sanana') {
                $harborName = 'SANANA';
                $this->info('Ship name for shipment header with code '.$shipmentHeader->shipment_number.' is '.$shipName.' so harbor name is '.$harborName);
            }
            $shipmentHeader->update([
                'harbor_name' => $harborName,
            ]);

        }

        $this->info('All harbor name for shipment header has been updated');
    }
}
