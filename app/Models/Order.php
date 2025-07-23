<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'txnid',
        'full_name',
        'email',
        'phone',
        'amount',
        'status',
        'shipping_address',
        'billing_address',
        'address',
        'city',
        'postal_code',
        'country',
        'awb',
        'razorpay_order_id',   // Add this
        'razorpay_payment_id', // Add this
    ];

        // App\Models\Order.php

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}