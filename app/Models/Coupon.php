<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_percentage',
        'is_universal',
        'category_id',
        'product_id',
        'valid_from',
        'valid_to'
    ];

    protected $casts = [
    'is_universal' => 'boolean',
    'valid_from' => 'datetime',
    'valid_to' => 'datetime',
    'product_ids' => 'array', // Important to auto-cast JSON
];


    // Validation rules for creating/updating coupons
    public static function rules($id = null)
    {
        return [
            'code' => 'required|string|unique:coupons,code,'.$id,
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'is_universal' => 'sometimes|boolean',
            'category_id' => 'nullable|exists:categories,id',
            'product_id' => 'nullable|exists:products,id',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
        ];
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function products()
{
    return $this->belongsToMany(Product::class, 'coupon_product');
}

    // Helper method to check if coupon is currently valid
    public function isValid()
    {
        $now = now();

        if ($this->valid_from && $this->valid_from->gt($now)) {
            return false;
        }

        if ($this->valid_to && $this->valid_to->lt($now)) {
            return false;
        }

        return true;
    }

    // Helper method to check if coupon applies to a specific product
    public function appliesToProduct($product)
    {
        if ($this->is_universal) {
            return true;
        }

        if ($this->category_id && $product->category_id == $this->category_id) {
            return true;
        }

        if ($this->product_id && $product->id == $this->product_id) {
            return true;
        }

        return false;
    }
}
