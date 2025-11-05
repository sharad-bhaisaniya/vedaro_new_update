<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'image', 
          'icon',
        'banner_image',
        'active',
        'showOnHome', // ✅ added
    ];
    
    public function products()
{
    return $this->hasMany(Product::class, 'category');
}
}
