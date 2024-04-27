<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Report\ShipmentClientReportController;
use App\Http\Controllers\Report\ShipmentReportController;
use App\Http\Controllers\Shipment\ShipmentArchiveController;
use App\Http\Controllers\Shipment\ShipmentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('barebone', ['title' => 'This is Title']);
    })->name('barebone');
    Route::prefix('dashboard')->group(function () {
        // * New Route
        Route::prefix('pengiriman')->group(function () {
            Route::controller(ShipmentController::class)->name('shipments-2.')->group(function () {
                Route::get('list', 'index')->middleware('can:view-shipment')->name('index');
                Route::get('tambah', 'create')->middleware('can:create-shipment')->name('create');
                Route::get('{uuid}/detail', 'show')->middleware('can:view-shipment')->name('show');
                Route::post('store', 'store')->middleware('can:delete-shipment')->name('store');
                // Route::get('laporan', 'report')->name('report');
            });

            Route::controller(ShipmentArchiveController::class)->name('shipments-2.')->group(function () {
                Route::get('arsip', 'index')->middleware('can:view-shipment')->name('archive');
            });
        });

        Route::prefix('pembayaran')->group(function () {
            Route::controller(PaymentController::class)->name('payment.')->group(function () {
                Route::get('cek-pembayaran', 'index')->middleware('can:view-payment')->name('index');
                Route::get('/{uuid}/detail', 'show')->middleware('can:show-payment')->name('show');
                Route::post('{uuid}/generate-invoice', 'generateInvoice')->middleware('can:resolve-payment')->name('generate-invoice');
                Route::post('{uuid}/confirmation-payment', 'confirmationPayment')->middleware('can:resolve-payment')->name('confirmation-payment');
            });
        });

        Route::prefix('invoices')->group(function () {
            Route::controller(InvoiceController::class)->name('invoice.')->group(function () {
                Route::get('{uuid}/detail', 'show')->middleware('can:show-payment')->name('show');
            });
        });

        Route::prefix('laporan')->group(function () {
            Route::get('pengiriman-pelanggan', ShipmentClientReportController::class)->middleware('can:report-shipment-client')->name('shipment-client-report');
            Route::get('pengiriman', [ShipmentReportController::class, 'index'])->middleware('can:report-shipment')->name('shipment-report.index');
        });

        Route::prefix('users')->group(function () {
            Route::controller(UserController::class)->name('users.')->group(function () {
                Route::get('/', 'index')->middleware('can:view-user')->name('index');
                Route::get('{uuid}/edit', 'show')->middleware('can:edit-user')->name('show');
                Route::post('{uuid}/update', 'update')->middleware('can:edit-user')->name('update');
            });
        });
        // * End New Route
    });
});
