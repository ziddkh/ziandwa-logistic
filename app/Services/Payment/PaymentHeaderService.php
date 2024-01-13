<?php

namespace App\Services\Payment;

use App\Models\Payment\PaymentHeader;

class PaymentHeaderService
{
    protected $paymentHeader;

    public function __construct(PaymentHeader $paymentHeader)
    {
        $this->paymentHeader = $paymentHeader;
    }

    public function generatePaymentNumber()
    {
        $abbreviation = 'TSL';
        $prefix = 'PAY';
        $date = date('Ymd');
        $lastSequence = 2022;
        $lastPayment = $this->paymentHeader->where('payment_number', 'like', $abbreviation.'/'.$prefix.'/'.'%')->latest('payment_number')->first();
        if (! empty($lastPayment)) {
            $lastSequence = substr($lastPayment->payment_number, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $paymentNumber = $abbreviation.'/'.$prefix.'/'.$date.'/'.$nextSequence;

        return $paymentNumber;
    }
}
