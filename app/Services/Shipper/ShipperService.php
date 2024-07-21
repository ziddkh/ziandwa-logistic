<?php

namespace App\Services\Shipper;

use App\Models\Shipper;

class ShipperService
{
    public static function generateDocumentNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'SHPM';
        $currentYear = date('Y');
        $date = date('Ymd');
        $lastSequence = 2023;
        $lastData = Shipper::where('document_number', 'like', "$abbreviation/$prefix/$currentYear%")->latest('document_number')->first();
        if (! empty($lastData)) {
            $lastSequence = (int)substr($lastData->document_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $lastDocumentNumber = "$abbreviation/$prefix/$date/$nextSequence";

        return $lastDocumentNumber;
    }
}
