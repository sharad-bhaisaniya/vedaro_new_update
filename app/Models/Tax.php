<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $table = 'taxes';

    protected $fillable = [
        'name',
        'tax_group',
        'rate',
        'is_active',
        'code',
        'description',
    ];

    protected $casts = [
        'rate' => 'float',
        'is_active' => 'boolean',
    ];
       public function groups()
    {
        return $this->belongsToMany(TaxGroup::class, 'tax_group_tax');
    }
}
