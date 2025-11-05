<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'weight',
        'price',
        'stock',
        'discount_price',
        'sku',
        'attributes',
    ];

    protected $casts = [
        'attributes' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Auto-calculated final price based on product discount


    // Auto-calculated final price based on product discount
    public function getFinalPriceAttribute()
    {
        // Use discount_price if available, otherwise apply product-level discount
        if ($this->discount_price) {
            return $this->discount_price;
        }

        $discountPercent = $this->product->discountPercentage ?? 0;
        if ($discountPercent >= 10) {
            return $this->price - ($this->price * ($discountPercent / 100));
        }

        return $this->price;
    }

    /**
     * Get effective price for display
     */
    public function getEffectivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }
}
