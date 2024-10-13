<?php

namespace App\Services\Invoice;

use App\Models\Invoice\InvoiceHeader;

class InvoiceService
{
    protected $invoiceHeader;

    public function __construct(InvoiceHeader $invoiceHeader)
    {
        $this->invoiceHeader = $invoiceHeader;
    }

    public function generateInvoiceNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'INV';
        $date = date('Ymd');
        $lastSequence = 2022;
        $lastInvoice = $this->invoiceHeader::withTrashed()->where('invoice_number', 'like', $abbreviation.'/'.$prefix.'/'.'%')->latest('invoice_number')->first();
        if (! empty($lastInvoice)) {
            $lastSequence = substr($lastInvoice->invoice_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $invoiceNumber = $abbreviation.'/'.$prefix.'/'.$date.'/'.$nextSequence;

        return $invoiceNumber;
    }
}
