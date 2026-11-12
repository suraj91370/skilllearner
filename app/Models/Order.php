<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'sponsor_id',
        'package_name',
        'package_slug',
        'amount',
        'original_amount',
        'coupon_code',
        'coupon_discount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'failure_reason',
        'refund_status',
        'refund_amount',
        'refund_reason',
        'refunded_at',
        'invoice_number',
        'gateway_payload',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'original_amount' => 'decimal:2',
            'coupon_discount' => 'decimal:2',
            'refund_amount' => 'decimal:2',
            'refunded_at' => 'datetime',
            'gateway_payload' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isRefunded(): bool
    {
        return $this->payment_status === 'refunded' || $this->refund_status === 'approved';
    }

    public function isFailed(): bool
    {
        return in_array($this->payment_status, ['failed', 'cancelled']);
    }

    /**
     * Generate or return existing unique invoice number.
     */
    public function getOrGenerateInvoiceNumber(): string
    {
        if (! empty($this->invoice_number)) {
            return $this->invoice_number;
        }

        $inv = 'INV-SKL-'.date('Y').'-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
        $this->update(['invoice_number' => $inv]);

        return $inv;
    }
}
