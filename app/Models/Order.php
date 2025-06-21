<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    /**
     * Get the formatted total amount.
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Get the status badge class for display.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-warning',
            self::STATUS_CONFIRMED => 'bg-info',
            self::STATUS_COMPLETED => 'bg-success',
            self::STATUS_CANCELLED => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Check if the order can be cancelled.
     */
    public function canBeCancelled()
    {
        return in_array($this->status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    /**
     * Calculate the total amount from order items.
     */
    public function calculateTotal()
    {
        return $this->orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    /**
     * Update the total amount based on order items.
     */
    public function updateTotal()
    {
        $this->update(['total_amount' => $this->calculateTotal()]);
    }

    /**
     * Scope to filter orders by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter orders by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
