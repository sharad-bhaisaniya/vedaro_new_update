<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * Display a comprehensive dashboard of Purchase, Sales, and Inventory reports.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // 1. --- Date Filtering and Initialization ---
        // Default to the last 6 months for initial load
        $toDate = $request->input('to_date') ? Carbon::parse($request->input('to_date'))->endOfDay() : Carbon::now()->endOfDay();
        $fromDate = $request->input('from_date') ? Carbon::parse($request->input('from_date'))->startOfDay() : Carbon::now()->subMonths(6)->startOfDay();

        // Ensure from_date is not after to_date
        if ($fromDate->gt($toDate)) {
            $fromDate = $toDate->subMonths(6)->startOfDay(); // Fallback if dates are invalid
        }

        // 2. --- Fetch Data with Date Scopes ---

        // Fetch Purchases (Buy)
        $purchasesQuery = Purchase::with(['vendor', 'items'])
            ->whereBetween('invoice_date', [$fromDate, $toDate]);
        $purchases = $purchasesQuery->get();

        // Fetch Online Sales (Orders)
        // Assuming 'created_at' is the relevant date field for Orders
        $ordersQuery = Order::with('items')
            ->where('status', 'Completed') // Only count completed orders as successful sales
            ->whereBetween('created_at', [$fromDate, $toDate]);
        $orders = $ordersQuery->get();

        // Fetch Offline Sales (Invoices)
        // Assuming 'invoice_date' is the relevant date field for Invoices
        $invoicesQuery = Invoice::with('items')
            ->whereBetween('invoice_date', [$fromDate, $toDate]);
        $invoices = $invoicesQuery->get();

        // 3. --- Purchase KPIs (Buy) ---

        $totalSpend = $purchases->sum(function($purchase) {
             // Assuming PurchaseItem has a 'total_incl_tax' or similar field. 
             // If not, you may need to adjust this to calculate from item quantity and rate.
            return $purchase->items->sum('total_incl_tax') ?? 0; 
        });
        $purchaseCount = $purchases->count();
        $averagePurchaseValue = $purchaseCount > 0 ? $totalSpend / $purchaseCount : 0;

        // 4. --- Sales KPIs (Sell: Online + Offline) ---

        $totalOrderRevenue = $orders->sum('amount'); // Assuming Order model has a total 'amount' field
        $totalInvoiceRevenue = $invoices->sum('total'); // Assuming Invoice model has a total 'total' field
        $totalRevenue = $totalOrderRevenue + $totalInvoiceRevenue;
        $totalSalesCount = $orders->count() + $invoices->count();
        $averageSaleValue = $totalSalesCount > 0 ? $totalRevenue / $totalSalesCount : 0;
        
        // 5. --- Inventory KPI ---

        // Assuming 'current_stock' field exists on the Product model
        $totalCurrentStock = Product::sum('current_stock');


        // 6. --- Aggregate Data for Charts ---

        // Monthly Purchase Chart Data
        $purchasesByMonth = $purchases->groupBy(function ($purchase) {
            return $purchase->invoice_date->format('Y-m'); // Group by Year-Month for proper sorting
        })->map(function ($group) {
            return $group->sum(fn($p) => $p->items->sum('total_incl_tax') ?? 0);
        })->sortKeys()->toArray();

        // Monthly Sales Chart Data (Combined Orders and Invoices)
        $monthlySalesData = [];

        // Orders
        $orders->each(function ($order) use (&$monthlySalesData) {
            $monthKey = Carbon::parse($order->created_at)->format('Y-m');
            $monthlySalesData[$monthKey] = ($monthlySalesData[$monthKey] ?? 0) + $order->amount;
        });

        // Invoices
        $invoices->each(function ($invoice) use (&$monthlySalesData) {
            $monthKey = Carbon::parse($invoice->invoice_date)->format('Y-m');
            $monthlySalesData[$monthKey] = ($monthlySalesData[$monthKey] ?? 0) + $invoice->total;
        });
        
        // Sort keys to ensure chronological order
        ksort($monthlySalesData);

        // Standardize monthly keys across both datasets for Chart.js
        $allMonths = array_unique(array_merge(array_keys($purchasesByMonth), array_keys($monthlySalesData)));
        sort($allMonths);
        
        $finalPurchaseData = [];
        $finalSalesData = [];
        $chartLabels = [];

        foreach ($allMonths as $monthKey) {
            // Format label for display (e.g., 'Jan 2024')
            $chartLabels[] = Carbon::createFromFormat('Y-m', $monthKey)->format('M Y');
            // Ensure every month has a value (0 if not present)
            $finalPurchaseData[] = $purchasesByMonth[$monthKey] ?? 0;
            $finalSalesData[] = $monthlySalesData[$monthKey] ?? 0;
        }
        $allPurchases = Purchase::with('vendor')->get();

        // 6.5 --- Profit & Loss Calculation ---

        // Ensure numeric (remove formatting commas if any)
        $totalRevenueValue = (float) str_replace(',', '', $totalRevenue);
        $totalSpendValue = (float) str_replace(',', '', $totalSpend);

        $profitLossAmount = $totalRevenueValue - $totalSpendValue;
        $profitLossPercentage = $totalSpendValue > 0 ? ($profitLossAmount / $totalSpendValue) * 100 : 0;
        $isProfit = $profitLossAmount >= 0;


        // 7. --- Return View Data ---

        return view('admin.reports.index', [
            // Date Filter Values
            'fromDate' => $fromDate->format('Y-m-d'),
            'toDate' => $toDate->format('Y-m-d'),

            // Purchase (Buy) KPIs
            'totalSpend' => number_format($totalSpend, 2),
            'purchaseCount' => $purchaseCount,
            'averagePurchaseValue' => number_format($averagePurchaseValue, 2),

            // Sales (Sell) KPIs
            'totalRevenue' => number_format($totalRevenue, 2),
            'salesCount' => $totalSalesCount,
            'averageSaleValue' => number_format($averageSaleValue, 2),

            // Inventory KPI
            'totalCurrentStock' => number_format($totalCurrentStock),
            'productsInStock' => Product::where('current_stock', '>', 0)->count(),
            
            // Chart Data
            'chartLabels' => $chartLabels,
            'purchaseData' => $finalPurchaseData,
            'salesData' => $finalSalesData,
            
            // Raw data for detailed tables
            'purchases' => $purchases,
            'orders' => $orders,
            'invoices' => $invoices,

            // display  purchases
            'allPurchases' =>$allPurchases,
            'profitLossAmount' => number_format($profitLossAmount, 2),
            'profitLossPercentage' => number_format($profitLossPercentage, 2),
            'isProfit' => $isProfit,

        ]);
    }
}