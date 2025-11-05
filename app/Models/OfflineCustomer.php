<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'pincode',
    ];

    /**
     * Optional relation to registered users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Sales invoices created for this offline customer
     */

}
