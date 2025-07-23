<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'email',
        'phone',
        'note',
    ];

    // Optional: relationships
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
