<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_qty',
        'customer_id', // Foreign key for User
        'total',
        'size',     // new
        'weight',   // new
    ];

    /**
     * Relationship with Product model.
     * A Cart belongs to a Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relationship with User model.
     * A Cart belongs to a User (customer).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id'); // 'customer_id' is the foreign key
    }
}
