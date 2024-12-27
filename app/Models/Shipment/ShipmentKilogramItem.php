<?php

namespace App\Models\Shipment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentKilogramItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'shipment_header_id',
        'width',
        'length',
        'height',
        'vol_weight',
        'price',
    ];

    protected $appends = [
        'price_formatted'
    ];

    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function header(): BelongsTo
    {
        return $this->belongsTo(
            related: ShipmentHeader::class,
            foreignKey: 'shipment_header_id'
        );
    }
}
