<?php

namespace App\Models\Payment;

use App\Models\Invoice\InvoiceHeader;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class PaymentDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'payment_header_id',
        'invoice_header_id',
        'payment_date',
        'payment_status',
        'payment_amount',
        'payment_proof',
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

    public function paymentHeader(): BelongsTo
    {
        return $this->belongsTo(PaymentHeader::class);
    }

    public function invoiceHeader(): BelongsTo
    {
        return $this->belongsTo(InvoiceHeader::class);
    }
}
