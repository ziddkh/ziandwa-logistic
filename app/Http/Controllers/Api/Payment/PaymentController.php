<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\Shipment\ShipmentHeader;

class PaymentController extends Controller
{
    public function show($code)
    {
        $code = str_replace('-', '/', $code);
        $shipment = ShipmentHeader::with('paymentHeader')->where('shipment_number', 'LIKE', '%'.$code)->firstOrFail();

        return response()->json([
            'redirect_url' => route('payment.show', $shipment->paymentHeader->uuid),
        ]);
    }
}
