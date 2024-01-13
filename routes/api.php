<?php

use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Report\ExportShipmentClientReportController;
use App\Http\Controllers\Api\Report\ExportShipmentReportController;
use App\Http\Controllers\Api\Shipment\ShipmentHeaderController;
use App\Http\Controllers\Api\Shipment\ShipmentItemController;
use App\Http\Controllers\DestinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.')->group(function () {
    Route::apiResource('destinations', DestinationController::class)->only(['index', 'show']);
    Route::apiResource('shipment-items', ShipmentItemController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::apiResource('shipment-headers', ShipmentHeaderController::class)->only(['show', 'update', 'destroy']);
    Route::apiResource('payments', PaymentController::class)->only(['show']);
    Route::prefix('report')->name('report.')->group(function () {

        Route::prefix('export')->name('export.')->group(function () {
            Route::get('shipments', ExportShipmentReportController::class)->name('shipments');
            Route::get('shipment-clients', ExportShipmentClientReportController::class)->name('shipment-clients');
        });
    });
});
