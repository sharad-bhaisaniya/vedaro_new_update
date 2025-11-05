<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
                'user_id','customer_name', 'invoice_number', 'order_number',
        'invoice_date', 'paid_amount', 'total','due_amount',   'customer_address',
    'customer_gstin', 'admin_gstin','offline_online'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }


}
