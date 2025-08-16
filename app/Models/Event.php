<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'first_name',
        'last_name',
        'address',
        'city',
        'pincode',
        'state',
        'country',
        'phone',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id'
    ];
      
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
