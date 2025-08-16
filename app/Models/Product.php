<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    'discountPercentage',
    'discountPrice',
    'image1',
    'image2',
    'image3',
    'current_stock',     // updated from 'stock'
    'total_stock',       // new
    'size_stock',        // new
    'shipping_fee',
    'availability',
    'on_sell',
    'add_timer',
    'timer_end_at',
];




protected $casts = [
    'availability' => 'boolean',
    'on_sell' => 'boolean',
    'add_timer' => 'boolean',
    'timer_end_at' => 'datetime',
    'multiple_weights' => 'array',
    'size_stock' => 'array', // new
];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
