<?php

namespace App\Models\Payment;

use App\Models\PaymentAdditional;
use App\Models\Shipment\ShipmentHeader;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class PaymentHeader extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'shipment_header_id',
        'payment_number',
        'payment_method',
        'payment_status',
        'additional_payment',
        'total_payment',
    ];

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected $append = [
        'grand_total_payment',
    ];

    public function getGrandTotalPaymentAttribute()
    {
        return $this->total_payment - $this->discount;
    }

    public function shipmentHeader(): BelongsTo
    {
        return $this->belongsTo(ShipmentHeader::class);
    }

    public function paymentDetails(): HasMany
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function latestPaymentDetail()
    {
        return $this->hasOne(PaymentDetail::class)->latest();
    }

    public function paymentAdditionals(): HasMany
    {
        return $this->hasMany(PaymentAdditional::class);
    }
}
