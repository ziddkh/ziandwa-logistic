<?php

namespace App\Models\Shipment;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class ShipmentItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'shipment_header_id',
        'type',
        'ship_name',
        'width',
        'length',
        'height',
        'vol_weight',
        'price',
        'description',
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

    public function scopeToday($query, $column = 'created_at')
    {
        return $query->whereDate($column, Carbon::today());
    }

    // public function scopeBeforeDate($query, $column = 'created_at', $date)
    // {
    //     return $query->whereDate($column, '<=', $date);
    // }

    public function shipmentHeader(): BelongsTo
    {
        return $this->belongsTo(ShipmentHeader::class, 'shipment_header_id', 'id');
    }
}
