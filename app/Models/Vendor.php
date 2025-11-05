<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'display_name',
        'company_name',
        'salutation',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'gst_no',
        'pan_no',
        'hsn_code',
        'address',
        'billing_address',
        'shipping_address',
        'account_number',
        'bank_name',
        'ifsc_code',
        'branch_name',
        'status',
        'notes'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function vendorCredits()
    {
        return $this->hasMany(VendorCredit::class);
    }
}
