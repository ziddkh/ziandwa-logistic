<?php

namespace App\Services\Shipment;

use App\Models\Shipment\ShipmentHeader;

class ShipmentService
{
    public function __construct()
    {
        //
    }

    public function generateShipmentNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'SHP';
        $date = date('Ymd');
        $lastSequence = 2022;
        $lastShipment = ShipmentHeader::withTrashed()->where('shipment_number', 'like', $abbreviation.'/'.$prefix.'/'.'%')->latest('shipment_number')->first();
        if (! empty($lastShipment)) {
            $lastSequence = substr($lastShipment->shipment_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $shipmentNumber = $abbreviation.'/'.$prefix.'/'.$date.'/'.$nextSequence;

        return $shipmentNumber;
    }

    public function all()
    {
        //
    }
}
