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
    'weight',
    'productDescription1',
    'productDescription2',
    'price',
    'discountPercentage',
    'discountPrice',
    'image1',
    'image2',
    'image3',
    'stock',
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
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}