<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_type',
        'description',
        'amount',
        'expense_date',
        'payment_type',
        'transaction_number',
        'bill_image',
        'note',
    ];

    /**
     * Accessor to get formatted amount with ₹ symbol
     */
    public function getFormattedAmountAttribute()
    {
        return '₹' . number_format($this->amount, 2);
    }

    /**
     * Accessor to get formatted date (e.g., Nov 11, 2025)
     */
    public function getFormattedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->expense_date)->format('M d, Y');
    }
}
