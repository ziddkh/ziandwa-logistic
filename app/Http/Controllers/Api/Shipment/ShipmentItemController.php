<?php

namespace App\Http\Controllers\Api\Shipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentItem\StoreRequest;
use App\Http\Requests\ShipmentItem\UpdateRequest;
use App\Models\Shipment\ShipmentHeader;
use App\Models\Shipment\ShipmentItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShipmentItemController extends Controller
{
    protected $shipmentHeader;

    protected $shipmentItem;

    public function __construct(ShipmentHeader $shipmentHeader, ShipmentItem $shipmentItem)
    {
        $this->shipmentItem = $shipmentItem;
        $this->shipmentHeader = $shipmentHeader;

    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $shipment = $this->shipmentHeader->findOrFail($request->shipment_header_id);
            if ($request->type === 'bale') {
                $this->shipmentItem->create([
                    'shipment_header_id' => $shipment->id,
                    'ship_name' => !empty($request->ship_name) ? $request->ship_name : $shipment->shipmentItems->first()->ship_name,
                    'type' => $request->type,
                    'width' => $request->width,
                    'length' => $request->length,
                    'height' => $request->height,
                    'vol_weight' => $request->width * $request->length * $request->height / $shipment->typeOfShipment->freight,
                    'price' => $request->width * $request->length * $request->height / $shipment->typeOfShipment->freight * $shipment->destination_cost,
                ]);
            }

            if ($request->type === 'vehicle') {
                $this->shipmentItem->create([
                    'shipment_header_id' => $shipment->id,
                    'ship_name' => !empty($request->ship_name) ? $request->ship_name : $shipment->shipmentItems->first()->ship_name,
                    'type' => $request->type,
                    'price' => $request->price,
                    'description' => $request->description,
                ]);
            }
            $shipment->update([
                'total_vol_weight' => $shipment->shipmentItems->sum('vol_weight'),
            ]);
            $shipment->paymentHeader->update([
                'total_payment' => $shipment->shipmentItems->sum('price'),
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Shipment item created successfully',
                'shipment-item' => $shipment->shipmentItems->last(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function show($uuid)
    {
        $shipmentItem = $this->shipmentItem->where('uuid', $uuid)->firstOrFail();

        return response()->json([
            'shipment_item' => $shipmentItem,
        ]);
    }

    public function update(UpdateRequest $request, $uuid)
    {
        DB::beginTransaction();
        try {
            $shipmentItem = $this->shipmentItem->where('uuid', $uuid)->firstOrFail();
            $shipment = $shipmentItem->shipmentHeader;
            $freight = $shipment->typeOfShipment->freight;
            if ($request->type === 'bale') {
                $item = $request->only([
                    'width',
                    'length',
                    'height',
                ]);
                $item['ship_name'] = !empty($request->ship_name) ? $request->ship_name : $shipment->shipmentItems->first()->ship_name;
                $item['vol_weight'] = $item['width'] * $item['length'] * $item['height'] / $freight;
                $item['price'] = $item['vol_weight'] * $shipment->destination_cost;
            }

            if ($request->type === 'vehicle') {
                $item = $request->only([
                    'price',
                    'description',
                ]);
                $item['ship_name'] = !empty($request->ship_name) ? $request->ship_name : $shipment->shipmentItems->first()->ship_name;
            }
            $shipmentItem->update($item);
            $shipment->update([
                'total_vol_weight' => $shipment->shipmentItems->sum('vol_weight'),
            ]);
            $shipment->paymentHeader->update([
                'total_payment' => $shipment->shipmentItems->sum('price'),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Shipment item updated successfully',
                'shipment_item' => $shipmentItem->refresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $shipmentItem = $this->shipmentItem->where('uuid', $uuid)->firstOrFail();
            $shipment = $shipmentItem->shipmentHeader;
            $shipmentItem->delete();
            $shipment->update([
                'total_vol_weight' => $shipment->shipmentItems->sum('vol_weight'),
            ]);
            $shipment->paymentHeader->update([
                'total_payment' => $shipment->shipmentItems->sum('price'),
            ]);
            DB::commit();

            return response()->json([
                'message' => 'Shipment item deleted successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
