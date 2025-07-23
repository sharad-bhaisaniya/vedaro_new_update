<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'city',
        'state',
        'pincode',
        'country',
        'address',
          'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
