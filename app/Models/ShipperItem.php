<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipperItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'shipper_id',
      'recipient_name',
      'vol_weight',
      'colly',
      'price',
    ];

    public function header(): BelongsTo
    {
      return $this->belongsTo(Shipper::class, 'shipper_id');
    }
}
