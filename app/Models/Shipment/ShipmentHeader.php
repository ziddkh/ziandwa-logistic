<?php

namespace App\Models\Shipment;

use App\Models\Destination;
use App\Models\Payment\PaymentHeader;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class ShipmentHeader extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'shipment_number',
        'departure_date',
        'expected_arrival_date',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'type_of_shipment_id',
        'destination_id',
        'destination_cost',
        'harbor_name',
        'status',
        'remarks',
        'total_vol_weight',
        'cost_per_kg',
    ];

    protected $appends = [
        'total_colly',
        'total_price',
    ];

    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     */
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function scopeToday($query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::today());
    }

    public function getTotalCollyAttribute()
    {
        if ($this->relationLoaded('shipmentItems')) {
            return $this->shipmentItems->count();
        }

        return 0;
    }

    public function getTotalPriceAttribute()
    {
        if ($this->relationLoaded('shipmentItems')) {
            $totalPrice = 0;
            foreach ($this->shipmentItems as $item) {
                $totalPrice += $item->price;
            }

            return $totalPrice;
        }

        return 0;
    }

    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class, 'shipment_header_id', 'id');
    }

    public function paymentHeader(): HasOne
    {
        return $this->hasOne(PaymentHeader::class, 'shipment_header_id', 'id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }

    public function typeOfShipment(): BelongsTo
    {
        return $this->belongsTo(TypeOfShipment::class, 'type_of_shipment_id', 'id');
    }
}
