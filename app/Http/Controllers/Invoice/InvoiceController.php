<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice\InvoiceHeader;

class InvoiceController extends Controller
{
    protected $invoiceHeader;

    public function __construct(InvoiceHeader $invoiceHeader)
    {
        $this->invoiceHeader = $invoiceHeader;
    }

    public function show($uuid)
    {
        $title = 'Invoice Detail';
        $invoiceHeader = $this->invoiceHeader->with('paymentDetail.paymentHeader.shipmentHeader', 'invoiceItems')->where('uuid', $uuid)->firstOrFail();

        return view('pages.invoices.detail.index', compact('title', 'invoiceHeader'));
    }
}
