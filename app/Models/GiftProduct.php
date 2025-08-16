<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftProduct extends Model
{
    use HasFactory;

    protected $table = 'gift_products';  // Assuming your table name is 'gift_products'

    protected $fillable = [
        'product_name',
        'price',
        'size',
        'weight',
        'product_description1',
        'product_description2',
        'product_image1',
        'product_image2',
        'product_image3',
         'is_active',
        'valid_from',
        'valid_to',
        'minimum_cart_amount'
    ];

    protected $casts = [
    'valid_from' => 'datetime',
    'valid_to' => 'datetime',
];

}
