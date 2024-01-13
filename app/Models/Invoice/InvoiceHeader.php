<?php

namespace App\Models\Invoice;

use App\Models\Payment\PaymentDetail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class InvoiceHeader extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'departure_date',
        'expected_arrival_date',
        'total_amount',
        'remarks',
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

    protected $appends = ['created_at_formatted'];

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d M Y');
    }

    public function paymentDetail(): HasOne
    {
        return $this->hasOne(PaymentDetail::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
