<?php

namespace App\Console\Commands;

use App\Models\Invoice\InvoiceHeader;
use App\Models\Shipment\ShipmentHeader;
use Illuminate\Console\Command;

class MigrateDepartureDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:departure-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migration departure date, and expected_arrival_date from shipment_items table to shipment_headers table and from invoice_items table to invoice_headers table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $shipmentHeaders = ShipmentHeader::withTrashed()->with(['shipmentItems' => function ($q) {
            $q->withTrashed();
        }])->get();
        foreach ($shipmentHeaders as $shipmentHeader) {
            $departureDate = $shipmentHeader->shipmentItems->min('departure_date');
            $expectedArrivalDate = $shipmentHeader->shipmentItems->max('expected_arrival_date');
            $shipmentHeader->update([
                'departure_date' => $departureDate,
                'expected_arrival_date' => $expectedArrivalDate,
            ]);
        }

        $invoiceHeaders = InvoiceHeader::withTrashed()->with(['invoiceItems' => function ($q) {
            $q->withTrashed();
        }])->get();
        foreach ($invoiceHeaders as $invoiceHeader) {
            $departureDate = $invoiceHeader->invoiceItems->min('departure_date');
            $expectedArrivalDate = $invoiceHeader->invoiceItems->max('expected_arrival_date');
            $invoiceHeader->update([
                'departure_date' => $departureDate,
                'expected_arrival_date' => $expectedArrivalDate,
            ]);
        }

        $this->info('Migration departure date from shipment_items table to shipment_headers table success');
    }
}
