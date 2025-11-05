<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'productName',
        'coupon_code',
        'category',
        'size',
        'multiple_sizes',
        'weight',
        'multiple_weights',
        'productDescription1',
        'productDescription2',
        'price',
        'product_type',
        'discountPercentage',
        'discountPrice',
        'image1',
        'image2',
        'image3',
        'current_stock',
        'total_stock',
        'size_stock',
        'shipping_fee',
        'availability',
        'tax_rate',
        'on_sell',
        'hsn_code',
        'mrp',
        'barcode',
        'brand',
        'rfid',
        'add_timer',
        'timer_end_at',
        'eligible_for_itc',
    ];

    protected $casts = [
        'availability' => 'boolean',
        'on_sell' => 'boolean',
        'add_timer' => 'boolean',
        'timer_end_at' => 'datetime',
        'multiple_weights' => 'array',
        'size_stock' => 'array',
        'eligible_for_itc' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    
    public function identifiers()
    {
        return $this->hasMany(ProductIdentifier::class);
    }

    public function taxGroup()
    {
        return $this->belongsTo(TaxGroup::class, 'tax_rate');
    }

    public function wishlistedByUsers()
    {
        return $this->belongsToMany(User::class, 'wishlist_items', 'product_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get product variants if exists
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get variant by size
     */
    public function getVariantBySize($size)
    {
        return $this->variants()->where('size', $size)->first();
    }

    /**
     * Check if product has variants
     */
    public function hasVariants()
    {
        return $this->product_type === 'variant' && $this->variants()->exists();
    }

 
// public static function findByBarcode($barcode)
// {
//     // Search in product_identifiers table using qr_code field
//     $identifier = ProductIdentifier::where('qr_code', $barcode)
//                                   ->orWhere('rfid', $barcode)
//                                   ->first();
    
//     if ($identifier && $identifier->product) {
//         return $identifier->product;
//     }
    
//     return null;
// }

 

    /**
 * Format product for barcode response with variant support
 */
        public function getFormattedForBarcodeResponse()
        {
            // Load variants if not already loaded
            if (!$this->relationLoaded('variants')) {
                $this->load('variants');
            }

            // Determine correct price
            $effectivePrice = $this->discountPrice ?? $this->price;
            
            $baseData = [
                'id' => $this->id,
                'productName' => $this->productName,
                'barcode' => $this->barcode,
                'category' => $this->category,
                'category_name' => $this->category ? (is_object($this->category) ? $this->category->name : Category::find($this->category)?->name) : 'No Category',
                'hsn' => $this->hsn_code,
                'hsn_code' => $this->hsn_code,
                'tax_group_id' => $this->tax_rate,
                'eligible_for_itc' => $this->eligible_for_itc ?? false,
                'product_type' => $this->product_type,
                'price' => $this->price,
                'rate' => $effectivePrice,
                'discountPrice' => $this->discountPrice,
                'discount_price' => $this->discountPrice,
                'discountPercentage' => $this->discountPercentage,
                'size' => $this->size,
            ];

            // If product has variants, include variants data
            if ($this->hasVariants()) {
                Log::info('Product has variants, including in response. Variant count: ' . $this->variants->count());
                $baseData['variants'] = $this->variants->map(function($variant) {
                    $variantPrice = $variant->discount_price ?? $variant->price;
                    
                    return [
                        'id' => $variant->id,
                        'product_variant_id' => $variant->id,
                        'size' => $variant->size,
                        'price' => $variant->price,
                        'discount_price' => $variant->discount_price,
                        'rate' => $variantPrice,
                        'stock' => $variant->stock,
                        'weight' => $variant->weight,
                    ];
                });
            } else {
                Log::info('Product is simple type, no variants included');
            }

            return $baseData;
        }

    /**
     * Get effective price for display
     */
    public function getEffectivePriceAttribute()
    {
        return $this->discountPrice ?? $this->price;
    }
}