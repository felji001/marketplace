<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

    /**
     * Get the product that the order item belongs to.
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    /**
     * Get the total price for this order item.
     */
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Get the formatted total price.
     */
    public function getFormattedTotalPriceAttribute()
    {
        return '$' . number_format($this->total_price, 2);
    }

    /**
     * Get the formatted unit price.
     */
    public function getFormattedUnitPriceAttribute()
    {
        return '$' . number_format($this->unit_price, 2);
    }
}
