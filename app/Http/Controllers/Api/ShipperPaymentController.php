<?php

namespace App\Http\Controllers\Api;

use App\Enums\ShipperPaymentMethodEnums;
use App\Enums\ShipperPaymentStatusEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShipperPayment\StoreRequest;
use App\Models\Shipper;
use App\Models\ShipperPayment;
use App\Services\Shipper\ShipperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipperPaymentController extends Controller
{
    public function store(StoreRequest $request)
    {
        $shipper = Shipper::with(['items', 'payments'])->findOrFail($request->shipper_id);

        // $request->validate([
        //     'payment_amount' => [function ($attribute, $value, $fail) use ($request, $shipper) {
        //         if ($request->payment_method === ShipperPaymentMethodEnums::from('Bayar Nanti')->value) {
        //             if ($value > $shipper->total_price) {
        //                 $fail("Total bayar tidak boleh melebih total pembayaran");
        //             }
        //         }
        //     }]
        // ]);


        try {
            DB::beginTransaction();
            $paymentNumber = ShipperService::generatePaymentNumber();
            $payment = $shipper->payments()->create([
                'payment_number' => $paymentNumber,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === ShipperPaymentMethodEnums::from('Cash')->value ? ShipperPaymentStatusEnums::LUNAS : ShipperPaymentStatusEnums::BELUM_LUNAS,
                'payment_amount' => $request->payment_method === ShipperPaymentMethodEnums::from('Cash')->value ? $shipper->total_price : 0,
                'remaining_payment_amount' => $request->payment_method === ShipperPaymentMethodEnums::from('Cash')->value ? 0 : $shipper->total_price,
            ]);

            $invoiceNumber = ShipperService::generateInvoiceNumber();
            $invoice = $payment->invoice()->create([
                'document_number' => $invoiceNumber,
                'name' => $shipper->name,
                'departure_date' => $shipper->departure_date,
                'destination_id' => $shipper->destination_id,
                'destination_type' => $shipper->destination_type,
                'destination_name' => $shipper->destination_name,
                'destination_cost' => $shipper->destination_cost,
                'harbor_name' => $shipper->harbor_name,
                'ship_name' => $shipper->ship_name,
                'type_of_shipment_id' => $shipper->type_of_shipment_id,
                'type_of_shipment_name' => $shipper->type_of_shipment_name,
                'type_of_shipment_freight' => $shipper->type_of_shipment_freight,
                'status' => $shipper->status,
                'total_colly' => $shipper->total_colly,
                'total_vol_weight' => $shipper->total_vol_weight,
                'total_price' => $shipper->total_price,
                'payment_number' => $payment->payment_number,
                'payment_method' => $payment->payment_method,
                'payment_status' => $payment->payment_status,
                'payment_amount' => $payment->payment_amount,
                'remaining_payment_amount' => $payment->remaining_payment_amount,
            ]);

            foreach ($shipper->items as $item) {
                $invoice->items()->create([
                    'recipient_name' => $item->recipient_name,
                    'vol_weight' => $item->vol_weight,
                    'colly' => $item->colly,
                    'price' => $item->price,
                ]);
            }
            DB::commit();

            return response()->json([
                'message' => "Success create new invoice",
                // 'redirect_url' => route('shipper.invoice', $invoice->),
            ]);
        } catch (\Exception $_ENV) {
            DB::rollBack();
            return response()->json([
                'message' => "Failed create an invoice"
            ]);
        }
    }
}
