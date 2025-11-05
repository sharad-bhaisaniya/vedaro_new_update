<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_name',
        'item_code',
        'quantity',
        'unit_price',
        'discount_percentage',
        'net_price',
        'tax_amount',
        'total_incl_tax',
        'tax_group_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'net_price' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_incl_tax' => 'decimal:2',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

      public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function taxGroup()
    {
        return $this->belongsTo(TaxGroup::class);
    }
}
