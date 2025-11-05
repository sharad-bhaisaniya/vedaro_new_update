<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformaInvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'performa_invoice_id',
        'item_id',
        'variant_id',
        'variant_size',
        'item_name',
        'category',
        'quantity',
        'rate',
        'discount',
        'taxes',
        'eligible_for_itc',
        'amount',
    ];

    protected $casts = [
        'taxes' => 'array',
        'eligible_for_itc' => 'boolean',
    ];

    public function performaInvoice()
    {
        return $this->belongsTo(PerformaInvoice::class, 'performa_invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Accessor for tax details
     */
    public function getTaxDetailsAttribute()
    {
        if (empty($this->taxes)) {
            return collect();
        }

        $taxIds = is_string($this->taxes) ? json_decode($this->taxes, true) : $this->taxes;
        
        if (!is_array($taxIds) || empty($taxIds)) {
            return collect();
        }

        return \App\Models\Tax::whereIn('id', $taxIds)->get();
    }
}