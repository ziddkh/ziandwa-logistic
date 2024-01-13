<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function createTransaction($transaction, $customer)
    {
        $transaction = $this->transactionRepository->create($transaction, $customer);

        return $transaction;
    }
}
