<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformaInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offline_online',
        'customer_name',
        'customer_address',
        'customer_gstin',
        'admin_gstin',
        'performa_number',
        'order_number',
        'performa_date',
        'paid_amount',
        'total',
        'due_amount',
    ];

    public function items()
    {
        return $this->hasMany(PerformaInvoiceItem::class, 'performa_invoice_id');
    }
        /**
     * Accessor for tax details
     */
    public function getTaxDetailsAttribute()
    {
        if (empty($this->taxes)) {
            return collect(); // Return empty collection
        }

        $taxIds = is_string($this->taxes) ? json_decode($this->taxes, true) : $this->taxes;
        
        if (!is_array($taxIds) || empty($taxIds)) {
            return collect();
        }

        return \App\Models\Tax::whereIn('id', $taxIds)->get();
    }
    public function product()
{
    return $this->belongsTo(Product::class);
}

}
