<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Models\Shipment\ShipmentHeader;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportShipmentReportController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      $title = 'Laporan Pengiriman Untuk Pelanggan';
      $currentDate = Carbon::now()->format('Y-m-d');
      $shipmentsReports = ShipmentHeader::with([
          'shipmentItems',
          'paymentHeader.latestPaymentDetail.invoiceHeader'
      ]);

      if ($request->filled('departure_date')) {
          $shipmentsReports = $shipmentsReports->where('departure_date', $request->departure_date);
      } else {
          $shipmentsReports = $shipmentsReports->where('departure_date', '>=', $currentDate);
      }

      if ($request->filled('recipient_address')) {
          $recipientAddress = $request->recipient_address;
          $shipmentsReports = $shipmentsReports->where(function ($query) use ($recipientAddress) {
              $query->whereRaw('LOWER(recipient_address) LIKE ?', ['%'.strtolower($recipientAddress).'%'])
                  ->orWhereRaw('UPPER(recipient_address) LIKE ?', ['%'.strtoupper($recipientAddress).'%']);
          });
      }

      if ($request->filled('recipient_names')) {
        $recipientNames = array_map('trim', explode(',', $request->recipient_names));
        $shipmentsReports = $shipmentsReports->where(function ($query) use ($recipientNames) {
            foreach ($recipientNames as $name) {
                $query->orWhereRaw('LOWER(recipient_name) = ?', [strtolower($name)]);
            }
        });
    }

      $shipmentsReports = $shipmentsReports->get();
      return view('pages.reports.shipment-reports.export', compact('title', 'shipmentsReports'));
    }
}
