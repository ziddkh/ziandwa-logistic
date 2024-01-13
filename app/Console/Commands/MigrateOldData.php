<?php

namespace App\Console\Commands;

use App\Models\Destination;
use App\Models\Payment\PaymentHeader;
use App\Models\Shipment\ShipmentHeader;
use App\Models\Shipment\ShipmentItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:old-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migration old data from old database to new database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::transaction(function () {
            DB::table('destination_locations')->orderBy('id')->chunk(100, function ($destination_locations) {
                foreach ($destination_locations as $destination_location) {
                    Destination::create([
                        'name' => $destination_location->name,
                        'cost' => $destination_location->cost,
                    ]);
                }
            });

            DB::table('transactions')->orderBy('id')->chunk(100, function ($transactions) {
                foreach ($transactions as $transaction) {
                    $customer = DB::table('customers')->where('id', $transaction->customer_id)->first();
                    $destination = DB::table('destination_locations')->where('id', $transaction->destination_location_id)->first();
                    $transaction_details = DB::table('transaction_details')->where('transaction_id', $transaction->id)->get();
                    $total_vol_weight = 0;
                    $total_price = 0;
                    foreach ($transaction_details as $transaction_detail) {
                        $total_vol_weight += $transaction_detail->kg_volume;
                        $total_price += $transaction_detail->price;
                    }
                    // change transaction_code format from TSLTR202309100001 to TSL/SHP/20230910/0001
                    // change code here
                    $newShipmentNumber = 'TSL/SHP/'.date('Ymd', strtotime($transaction->created_at)).'/'.substr($transaction->code, -4);
                    $newPaymentNumber = 'TSL/PAY/'.date('Ymd', strtotime($transaction->created_at)).'/'.substr($transaction->code, -4);
                    $shipmentHeader = ShipmentHeader::create([
                        'shipment_number' => $newShipmentNumber,
                        'recipient_name' => $customer->name,
                        'recipient_phone' => $customer->phone_number,
                        'recipient_address' => $customer->delivery_address,
                        'type_of_shipment_id' => 1,
                        'destination_id' => $transaction->destination_location_id,
                        'destination_cost' => $destination->cost,
                        'status' => 'Pickup',
                        'total_vol_weight' => $total_vol_weight,
                    ]);

                    PaymentHeader::create([
                        'shipment_header_id' => $shipmentHeader->id,
                        'payment_number' => $newPaymentNumber,
                        'payment_status' => 'Belum Dibayar',
                        'total_payment' => $total_price,
                    ]);
                }
            });

            DB::table('transaction_details')->orderBy('id')->chunk(100, function ($transaction_details) {
                foreach ($transaction_details as $transaction_detail) {
                    $transaction = DB::table('transactions')->where('id', $transaction_detail->transaction_id)->first();
                    $newShipmentNumber = 'TSL/SHP/'.date('Ymd', strtotime($transaction->created_at)).'/'.substr($transaction->code, -4);
                    $shipment_header = DB::table('shipment_headers')->where('shipment_number', $newShipmentNumber)->first();
                    ShipmentItem::create([
                        'shipment_header_id' => $shipment_header->id,
                        'departure_date' => $transaction_detail->delivery_date,
                        'expected_arrival_date' => date('Y-m-d', strtotime($transaction_detail->delivery_date.' + 7 days')),
                        'ship_name' => $transaction->ship_name,
                        'width' => $transaction_detail->width,
                        'height' => $transaction_detail->height,
                        'length' => $transaction_detail->length,
                        'vol_weight' => $transaction_detail->kg_volume,
                        'price' => $transaction_detail->price,
                    ]);
                }
            });
        }, 5);

        $this->info('Migration old data from old database to new database success!');
    }
}
