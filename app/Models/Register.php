<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable  // Ensure it's extending Authenticatable
{
    use HasFactory;

    protected $table = 'users';  // Ensure the model is linked to the correct table

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    // Add any additional relationships or methods as needed
}
