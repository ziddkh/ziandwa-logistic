<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipperInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shipper_payment_id',
        'document_number',
        'name',
        'departure_date',
        'destination_id',
        'destination_type',
        'destination_name',
        'destination_cost',
        'harbor_name',
        'ship_name',
        'type_of_shipment_id',
        'type_of_shipment_name',
        'type_of_shipment_freight',
        'status',
        'total_colly',
        'total_vol_weight',
        'total_price',
        'payment_number',
        'payment_method',
        'payment_status',
        'payment_amount',
        'remaining_payment_amount',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(
            related: ShipperInvoiceItem::class,
            foreignKey: 'shipper_invoice_id'
        );
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(
            related: ShipperPayment::class,
            foreignKey: 'shipper_payment_id'
        );
    }
}
