<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIdentifier extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'qr_code',
        'rfid',
    ];

    /**
     * Get the product that owns the identifier.
     */
 
       public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Find by any identifier (qr_code or rfid)
     */
    public static function findByIdentifier($identifier)
    {
        return static::where('qr_code', $identifier)
                                ->first();
    }

    /**
     * Find product by any identifier (qr_code or rfid)
     */
    public static function findProductByIdentifier($identifier)
    {
        $productIdentifier = static::where('qr_code', $identifier)
                                  ->first();
        
        return $productIdentifier ? $productIdentifier->product : null;
    }
    
}