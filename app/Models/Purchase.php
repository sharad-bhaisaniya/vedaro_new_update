<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'vendor_id',
        'vendor_gstin',
        'grand_total'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'grand_total' => 'decimal:2',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
    public function purchaseReports()
{
    // 1. Fetch all purchases (adjust date range as needed)
    $purchases = Purchase::with(['vendor', 'items'])->orderBy('invoice_date', 'desc')->get();

    // 2. Calculate KPIs
    $totalSpend = $purchases->sum(function($purchase) {
        return $purchase->items->sum('total_incl_tax');
    });
    $purchaseCount = $purchases->count();
    $averagePurchaseValue = $purchaseCount > 0 ? $totalSpend / $purchaseCount : 0;
    $totalTaxPaid = $purchases->sum(function($purchase) {
        return $purchase->items->sum('tax_amount');
    });

    // 3. Aggregate for Charts
    $purchasesByMonth = $purchases->groupBy(function ($purchase) {
        return $purchase->invoice_date->format('M Y'); // Group by Month and Year
    })->map(function ($group) {
        return $group->sum(fn($p) => $p->items->sum('total_incl_tax'));
    })->take(6)->toArray(); // Show last 6 months

    $purchasesByVendor = $purchases->groupBy(function ($purchase) {
        return $purchase->vendor->name ?? 'Unknown Vendor';
    })->map(function ($group) {
        return $group->sum(fn($p) => $p->items->sum('total_incl_tax'));
    })->sortDesc()->take(5)->toArray(); // Top 5 Vendors

    return view('admin.reports.index', [
        'purchases' => $purchases, // Still needed for the detail table
        'totalSpend' => $totalSpend,
        'purchaseCount' => $purchaseCount,
        'averagePurchaseValue' => $averagePurchaseValue,
        'totalTaxPaid' => $totalTaxPaid,
        'purchasesByMonth' => $purchasesByMonth,
        'purchasesByVendor' => $purchasesByVendor,
    ]);
}
}
