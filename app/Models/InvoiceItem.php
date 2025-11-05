<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 'item_name', 'category',
        'quantity', 'rate', 'discount', 'taxes',
        'eligible_for_itc', 'amount'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

      protected $casts = [
        'taxes' => 'array', // this will auto-convert JSON to PHP array
    ];


    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
     // Custom accessor for fetching tax details
   public function getTaxDetailsAttribute()
{
    $taxIds = $this->taxes;

    // If it's a JSON string, decode it
    if (is_string($taxIds)) {
        $taxIds = json_decode($taxIds, true);
    }

    // Ensure it's always an array
    if (!is_array($taxIds)) {
        $taxIds = [];
    }

    return Tax::whereIn('id', $taxIds)->get();
}

        // Link to Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    // Link to Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // ✅ Link to TaxGroup
    public function taxGroup()
    {
        return $this->belongsTo(TaxGroup::class, 'tax_group_id');
    }


}
