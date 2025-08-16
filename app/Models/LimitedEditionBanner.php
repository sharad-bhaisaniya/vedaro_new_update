<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LimitedEditionBanner extends Model
{
    protected $fillable = ['title', 'description', 'image'];
    
  
    public function products()
{
    return $this->belongsToMany(Product::class);
}
}


