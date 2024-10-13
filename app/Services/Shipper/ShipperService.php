<?php

namespace App\Services\Shipper;

use App\Models\Shipper;
use App\Models\ShipperInvoice;
use App\Models\ShipperPayment;

class ShipperService
{
    public static function generateDocumentNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'SHPM';
        $currentYear = date('Y');
        $date = date('Ymd');
        $lastSequence = 2023;
        $lastData = Shipper::withTrashed()->where('document_number', 'like', "$abbreviation/$prefix/$currentYear%")->latest('document_number')->first();
        if (! empty($lastData)) {
            $lastSequence = (int)substr($lastData->document_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $lastDocumentNumber = "$abbreviation/$prefix/$date/$nextSequence";

        return $lastDocumentNumber;
    }

    public static function generatePaymentNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'SPYM';
        $currentYear = date('Y');
        $date = date('Ymd');
        $lastSequence = 2023;
        $lastData = ShipperPayment::withTrashed()->where('payment_number', 'like', "$abbreviation/$prefix/$currentYear%")->latest('payment_number')->first();
        if (! empty($lastData)) {
            $lastSequence = (int)substr($lastData->payment_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $lastDocumentNumber = "$abbreviation/$prefix/$date/$nextSequence";

        return $lastDocumentNumber;
    }

    public static function generateInvoiceNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'SINV';
        $currentYear = date('Y');
        $date = date('Ymd');
        $lastSequence = 2023;
        $lastData = ShipperInvoice::withTrashed()->where('document_number', 'like', "$abbreviation/$prefix/$currentYear%")->latest('document_number')->first();
        if (! empty($lastData)) {
            $lastSequence = (int)substr($lastData->document_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $lastDocumentNumber = "$abbreviation/$prefix/$date/$nextSequence";

        return $lastDocumentNumber;
    }
}
