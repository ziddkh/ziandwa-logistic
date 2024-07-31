<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipperPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shipper_id',
        'payment_number',
        'payment_method',
        'payment_status',
        'payment_amount',
        'remaining_payment_amount',
    ];

    public function shipper(): BelongsTo
    {
        return $this->belongsTo(
            related: Shipper::class
        );
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(
            related: ShipperInvoice::class
        );
    }
}
