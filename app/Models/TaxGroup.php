<?php

// app/Models/TaxGroup.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'tax_group_tax');
    }
}
