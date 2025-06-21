<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Get the user (producer) that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the producer that owns the product (alias for user).
     */
    public function producer()
    {
        return $this->user();
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    /**
     * Check if the product is in stock.
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Check if the product has sufficient stock for a given quantity.
     */
    public function hasSufficientStock($quantity)
    {
        return $this->stock >= $quantity;
    }

    /**
     * Reduce stock by a given quantity.
     */
    public function reduceStock($quantity)
    {
        if ($this->hasSufficientStock($quantity)) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Scope to filter products by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to filter products by producer.
     */
    public function scopeByProducer($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter products that are in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Get WhatsApp inquiry URL for this product.
     */
    public function getWhatsAppInquiryUrl($quantity = 1, $customMessage = null)
    {
        return \App\Helpers\WhatsAppHelper::generateProductInquiryUrl($this, $quantity, $customMessage);
    }

    /**
     * Check if the seller has WhatsApp contact available.
     */
    public function hasWhatsAppContact()
    {
        return !empty($this->user->whatsapp_number) &&
               \App\Helpers\WhatsAppHelper::isValidWhatsAppNumber($this->user->whatsapp_number);
    }
}
