<?php

namespace App\Http\Controllers\Shipper;

use App\Enums\ShipperPaymentStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\ShipperPayment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipperPaymentController extends Controller
{
    public function konfirmasiPembayaran($paymentNumber) {
        $paymentNumberFormatted = str_replace('-', '/', $paymentNumber);

        try {
            $payment = ShipperPayment::with(['shipper', 'invoice'])->where('payment_number', $paymentNumberFormatted)->where('payment_status', ShipperPaymentStatusEnums::from('Belum Lunas')->value)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $paymentAmount = $payment->remaining_payment_amount;

        try {
            DB::beginTransaction();
            $payment->update([
                'payment_amount' => $paymentAmount,
                'remaining_payment_amount' => 0,
                'payment_status' => ShipperPaymentStatusEnums::LUNAS,
            ]);

            $payment->invoice()->update([
                'payment_amount' => $paymentAmount,
                'remaining_payment_amount' => 0,
                'payment_status' => ShipperPaymentStatusEnums::LUNAS,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json([
            'redirect_url' => route('shipper.show', $payment->shipper->uuid),
        ]);
    }
}
