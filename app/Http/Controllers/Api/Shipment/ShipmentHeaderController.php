<?php

namespace App\Http\Controllers\Api\Shipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipment\UpdateRequest;
use App\Models\Shipment\ShipmentHeader;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShipmentHeaderController extends Controller
{
    protected $shipmentHeader;

    public function __construct(ShipmentHeader $shipmentHeader)
    {
        $this->shipmentHeader = $shipmentHeader;
    }

    public function show($uuid)
    {
        $shipmentHeader = $this->shipmentHeader->with('destination')->where('uuid', $uuid)->first();

        return response()->json([
            'shipment_header' => $shipmentHeader,
        ]);
    }

    public function update(UpdateRequest $request, $uuid)
    {
        DB::beginTransaction();
        try {
            $shipmentHeader = $this->shipmentHeader->where('uuid', $uuid)->firstOrFail();
            $shipmentHeader->update([
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'recipient_address' => $request->recipient_address,
                'departure_date' => $request->departure_date,
                'expected_arrival_date' => Carbon::parse($request->departure_date)->addDays(6),
                'destination_id' => $request->destination_id,
                'harbor_name' => $request->harbor_name,
                'destination_cost' => $request->destination_cost,
            ]);
            $shipmentHeader->shipmentItems->each(function ($item) use ($shipmentHeader) {
                if ($item->type == 'bale') {
                    $item->update([
                        'price' => $item->vol_weight * $shipmentHeader->destination_cost,
                    ]);
                }
            });
            $shipmentHeader->paymentHeader->update([
                'total_payment' => max($shipmentHeader->shipmentItems->sum('price'), $shipmentHeader->destination_cost * 0.2),
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Shipment header updated successfully',
                'shipment_header' => $shipmentHeader->refresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function destroy($uuid)
    {
        $shipmentHeader = $this->shipmentHeader->with('shipmentItems', 'paymentHeader')->where('uuid', $uuid)->firstOrFail();
        $shipmentHeader->shipmentItems()->delete();
        $shipmentHeader->paymentHeader()->delete();
        $shipmentHeader->delete();

        return response()->json([
            'message' => 'Shipment header deleted successfully',
        ]);
    }
}
