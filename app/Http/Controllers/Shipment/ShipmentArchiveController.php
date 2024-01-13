<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Controller;
use App\Models\Shipment\ShipmentHeader;
use Carbon\Carbon;

class ShipmentArchiveController extends Controller
{
    public function index()
    {
        $title = 'List Pengiriman';
        $shipments = ShipmentHeader::with(['shipmentItems', 'paymentHeader.paymentDetails'])
            ->where('departure_date', '<=', Carbon::today()->format('Y-m-d'))
            ->latest('created_at')
            ->get();

        return view('pages.shipments-2.archive.index', compact('title', 'shipments'));
    }
}
