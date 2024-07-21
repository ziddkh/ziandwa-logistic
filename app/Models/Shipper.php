<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Shipper extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
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

    public function items(): HasMany
    {
      return $this->hasMany(ShipperItem::class, 'shipper_id');
    }
}
