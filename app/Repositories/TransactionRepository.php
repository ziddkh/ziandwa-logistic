<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function generateCode()
    {
        $prefix = 'TSLTR';
        $date = date('Ymd');
        $lastTransaction = Transaction::where('code', 'like', $prefix.$date.'%')->orderBy('code', 'desc')->first();
        $lastSequence = 0;
        if (! empty($lastTransaction)) {
            $lastSequence = substr($lastTransaction->code, -4);
        }
        $nextSequence = $lastSequence + 1;
        $nextSequence = sprintf('%04d', $nextSequence);
        $code = $prefix.$date.$nextSequence;

        return $code;
    }

    public function create($transaction, $customer)
    {
        $transaction = $this->transaction->create([
            'code' => $this->generateCode(),
            'customer_id' => $customer,
            'destination_location_id' => $transaction['destination_location_id'],
            'ship_name' => $transaction['ship_name'],
            'transaction_status' => 'Terdata',
        ]);

        return $transaction;
    }
}
