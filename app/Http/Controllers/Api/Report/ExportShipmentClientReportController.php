<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Shipment\ShipmentHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportShipmentClientReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $title = 'Laporan Pengiriman Untuk Pelanggan';

        $shipmentsReports = ShipmentHeader::with(['shipmentItems']);

        if ($request->filled('departure_date')) {
            $shipmentsReports = $shipmentsReports->where('departure_date', $request->departure_date);
        } else {
            $shipmentsReports = $shipmentsReports->where('departure_date', '>=', Carbon::today()->format('Y-m-d'));
        }

        if ($request->filled('recipient_address')) {
            $recipientAddress = $request->recipient_address;
            $shipmentsReports = $shipmentsReports->where(function ($query) use ($recipientAddress) {
                $query->whereRaw('LOWER(recipient_address) LIKE ?', ['%'.strtolower($recipientAddress).'%'])
                    ->orWhereRaw('UPPER(recipient_address) LIKE ?', ['%'.strtoupper($recipientAddress).'%']);
            });
        }

        $shipmentsReports = $shipmentsReports->get();

        return view('pages.reports.shipment-client-reports.export', compact('title', 'shipmentsReports'));
    }
}
