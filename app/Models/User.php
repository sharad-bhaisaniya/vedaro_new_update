<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'profile_image',
        'dob',
        'gender',
        'city',
        'pincode',
        'country',
        'address',
         'google_id',  // Add google_id here
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define the relationship between the User and Cart.
     * A User can have many Carts (one-to-many relationship).
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'customer_id'); // 'customer_id' in Cart table
    }

    // Define relationship with Rating model (you might already have it)
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
        public function userAddresses()
        {
            return $this->hasMany(UserAddress::class); // Assuming UserAddress is your address model
        }
    
    public function wishlistItems(): HasMany
{
    return $this->hasMany(WishlistItem::class);
}
}
