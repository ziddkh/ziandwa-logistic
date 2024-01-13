<?php

namespace App\Repositories\Shipment\ShipmentHeader;

use App\Models\Shipment\ShipmentHeader;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShipmentHeaderRepository implements ShipmentHeaderRepositoryInterface
{
    protected $shipmentHeader;

    public function __construct(ShipmentHeader $shipmentHeader)
    {
        $this->shipmentHeader = $shipmentHeader;
    }

    public function all()
    {
        return Cache::remember('shipment_headers.all', Carbon::parse('1 minute'), function () {
            return $this->shipmentHeader->all();
        });
    }

    public function find($uuid)
    {
        return Cache::remember('shipment_headers.find.'.$uuid, Carbon::parse('1 minute'), function () use ($uuid) {
            return $this->shipmentHeader->where('uuid', $uuid)->first();
        });
    }

    public function create(array $shipmentHeader, array $shipmentItems)
    {
        DB::beginTransaction();
        try {
            $totalVolWeight = collect($shipmentItems)->sum(function ($item) {
                return $item['vol_weight'];
            });
            $shipmentHeader = $this->shipmentHeader->create([
                'shipment_number' => $shipmentHeader['shipment_number'],
                'recipient_name' => $shipmentHeader['recipient_name'],
                'recipient_phone' => $shipmentHeader['recipient_phone'],
                'recipient_address' => $shipmentHeader['recipient_address'],
                'type_of_shipment_id' => $shipmentHeader['type_of_shipment_id'],
                'destination_id' => $shipmentHeader['destination_id'],
                'status' => 'pickup',
                'total_vol_weight' => $totalVolWeight,
            ]);
            $shipmentHeader->shipmentItems()->createMany($shipmentItems);
            DB::commit();
            Cache::forget('shipment_headers.all');

            return $shipmentHeader;
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Query Exception When Create Shipment Header : '.$e->getMessage());
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info('Exception When Create Shipment Header : '.$e->getMessage());
            throw $e;
        }
    }

    public function update($uuid, $shipmentHeaderNumber, array $shipmentHeaderData)
    {
        // DB::beginTransaction();
        // try {
        //     $shipmentHeader = $this->shipmentHeader
        //         ->where('uuid', $uuid)
        //         ->where('shipment_number', $shipmentHeaderNumber)
        //         ->firstOrFail();
        //     $shipmentHeader->update([
        //         'recipient_name' => $shipmentHeader['recipient_name'],
        //         'recipient_phone' => $shipmentHeader['recipient_phone'],
        //         'recipient_address' => $shipmentHeader['recipient_address'],
        //         'destination_id' => $shipmentHeader['destination_id'],
        //     ]);
        //     Cache::forget('shipment_headers.all');
        //     DB::commit();
        //     return $shipmentHeader;
        // } catch (ModelNotFoundException $e) {
        //     DB::rollBack();
        //     Log::error("Model Not Found Exception When Update Shipment Header : " . $e->getMessage());
        //     throw $e;
        // } catch (QueryException $e) {
        //     DB::rollBack();
        //     Log::error("Query Exception When Update Shipment Header : " . $e->getMessage());
        //     throw $e;
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     Log::info("Exception When Update Shipment Header : " . $e->getMessage());
        //     throw $e;
        // }
    }

    public function delete($uuid)
    {
        $shipmentHeader = $this->shipmentHeader->where('uuid', $uuid)->first();
        $shipmentHeader->delete();

        return $shipmentHeader;
    }
}
