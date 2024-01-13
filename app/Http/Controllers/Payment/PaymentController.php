<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Invoice\InvoiceHeader;
use App\Models\Payment\PaymentDetail;
use App\Models\Payment\PaymentHeader;
use App\Services\Invoice\InvoiceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $paymentHeader;

    protected $paymentDetail;

    protected $invoiceHeader;

    protected $invoiceService;

    public function __construct(PaymentHeader $paymentHeader, PaymentDetail $paymentDetail, InvoiceHeader $invoiceHeader, InvoiceService $invoiceService)
    {
        $this->paymentHeader = $paymentHeader;
        $this->paymentDetail = $paymentDetail;
        $this->invoiceHeader = $invoiceHeader;
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $title = 'List Pembayaran';

        return view('pages.payments.index', compact('title'));
    }

    public function searchPayment(Request $request)
    {
        //
    }

    public function show($uuid)
    {
        $title = 'Detail Pembayaran';
        $payment = $this->paymentHeader->with('shipmentHeader', 'paymentDetails.invoiceHeader')
            ->where('uuid', $uuid)
            ->whereHas('shipmentHeader.shipmentItems')
            ->firstOrFail();

        return view('pages.payments.detail.index', compact('title', 'payment'));
    }

    public function generateInvoice(Request $request)
    {
        DB::beginTransaction();
        $payment = $this->paymentHeader->where('uuid', $request->uuid)->firstOrFail();
        $payment->update([
            'payment_method' => $request->payment_method,
        ]);
        $payment->refresh();
        $invoiceHeader = $this->invoiceHeader->create([
            'invoice_number' => $this->invoiceService->generateInvoiceNumber(),
            'departure_date' => $payment->shipmentHeader->departure_date,
            'expected_arrival_date' => $payment->shipmentHeader->expected_arrival_date,
            'total_amount' => $payment->payment_method == 'DP' ? str_replace('.', '', $request->payment_amount) : $payment->total_payment - $payment->discount,
        ]);
        $payment->shipmentHeader->shipmentItems->map(function ($item) use ($invoiceHeader) {
            $itemArray = $item->toArray();
            $filteredArray = collect($itemArray)->except(['id', 'uuid', 'shipment_header_id', 'created_at', 'updated_at', 'deleted_at'])->toArray();
            $invoiceHeader->invoiceItems()->create($filteredArray);
        });
        $payment->paymentDetails()->create([
            'invoice_header_id' => $invoiceHeader->id,
            'payment_date' => Carbon::now(),
            'payment_status' => 'Pending',
        ]);
        DB::commit();

        return 'success';
    }

    public function confirmationPayment(Request $request, $uuid)
    {
        DB::beginTransaction();
        $paymentDetail = $this->paymentDetail->where('uuid', $uuid)->firstOrFail();
        $paymentDetail->update([
            'payment_status' => 'Sudah Dibayar',
        ]);

        $paymentDetail->paymentHeader->update([
            'payment_status' => 'Lunas',
        ]);

        DB::commit();

        return 'success';
    }
}
