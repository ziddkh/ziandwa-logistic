<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionReportController extends Controller
{
    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function report(Request $request)
    {
        $title = 'Laporan Detail Global';
        $transactions = $this->transaction->with(['customer', 'transaction_details'])->whereHas('transaction_details', function ($query) {
            $query->whereDate('delivery_date', Carbon::today());
        })->get();
        // get first transactions with transaction_details
        $transaction = $transactions->first();

        return view('pages.shipments.global-report.index', compact('title', 'transactions', 'transaction'));
    }
}
