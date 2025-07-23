<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
         protected $table = 'order_items';


  protected $fillable = [
    'order_id',
    'product_id',
    'product_qty',
    'price',
    'total',
];

         // OrderItem.php
        public function order()
        {
            return $this->belongsTo(Order::class);
        }
        // OrderItem.php
      public function product()
        {
            return $this->belongsTo(Product::class, 'product_id');
        }
                        

}

