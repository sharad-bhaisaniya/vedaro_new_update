<?php

namespace App\Http\Controllers;

use App\Models\OfflineCustomer;
use App\Models\Product;
use App\Models\TaxGroup;
use App\Models\Category;
use App\Models\PerformaInvoice;
use App\Models\PerformaInvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformaInvoiceController extends Controller
{
    // Display list of Performa Invoices
    public function index(Request $request)
    {
        $query = PerformaInvoice::query();

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('performa_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            switch ($request->status) {
                case 'paid':
                    $query->where('due_amount', 0);
                    break;
                case 'pending':
                    $query->where('due_amount', '>', 0);
                    break;
            }
        }

        // Date range filter
        if ($request->has('date_range') && !empty($request->date_range)) {
            switch ($request->date_range) {
                case 'week':
                    $query->whereBetween('performa_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('performa_date', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
                case 'quarter':
                    $query->whereBetween('performa_date', [now()->startOfQuarter(), now()->endOfQuarter()]);
                    break;
                case 'year':
                    $query->whereBetween('performa_date', [now()->startOfYear(), now()->endOfYear()]);
                    break;
            }
        }

        $performaInvoices = $query->orderBy('performa_date', 'desc')->paginate(10);

        $totalPerforma = PerformaInvoice::count();
        $paidPerforma = PerformaInvoice::where('due_amount', 0)->count();
        $pendingPerforma = PerformaInvoice::where('due_amount', '>', 0)->count();

        return view('admin.PerformaInvoice.index', compact(
            'performaInvoices',
            'totalPerforma',
            'paidPerforma',
            'pendingPerforma'
        ));
    }
    
    // Show create form
    public function create()
    {
        $customers = OfflineCustomer::all();
        $items = Product::with('category')->get();
            $users = \App\Models\User::all(); // Add this line for online customers
    
        $tax_groups = TaxGroup::with('taxes')->get();
        $categories = Category::all();
    
        $lastPerforma = PerformaInvoice::latest('id')->first();
        $nextPerformaNumber = $lastPerforma
            ? 'PI-' . str_pad(((int) substr($lastPerforma->performa_number, 5)) + 1, 5, '0', STR_PAD_LEFT)
            : 'PI-00001';
    
        return view('admin.PerformaInvoice.create', compact('customers', 'items', 'tax_groups', 'categories', 'nextPerformaNumber','users'));
    }
    
    // Store Performa Invoice
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'performa_date' => 'required|date',
            'paid_amount' => 'required|numeric|min:0',
            'offline_online' => 'required|in:online,offline',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string',
            'customer_address' => 'nullable|string',
            'city' => 'nullable|string',
            'pincode' => 'nullable|string',
            'customer_gstin' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.rate' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_group_id' => 'nullable|exists:tax_groups,id',
            'items.*.eligible_for_itc' => 'nullable|boolean',
        ]);
    
        try {
            DB::transaction(function() use ($request) {
                $userId = null;
                $customerName = $request->customer_name;
                
                if ($request->offline_online === 'online') {
                    // Handle online customer (from users table)
                    $user = \App\Models\User::where('first_name', explode(' ', $customerName)[0])
                        ->where('last_name', explode(' ', $customerName)[1] ?? '')
                        ->first();
                    
                    if ($user) {
                        $userId = $user->id;
                        
                        // Update user details if provided in the form
                        $updateData = [];
                        if ($request->filled('customer_email')) {
                            $updateData['email'] = $request->customer_email;
                        }
                        if ($request->filled('customer_phone')) {
                            $updateData['phone'] = $request->customer_phone;
                        }
                        if ($request->filled('customer_address')) {
                            $updateData['address'] = $request->customer_address;
                        }
                         if ($request->filled('city')) {
                            $updateData['city'] = $request->city;
                        }
                        if ($request->filled('pincode')) {
                            $updateData['pincode'] = $request->pincode;
                        }
                        
                        if ($request->filled('country')) {
                            $updateData['country'] = 'India';
                        }
                        
                        if (!empty($updateData)) {
                            $user->update($updateData);
                        }
                    } else {
                        // Create new user if not found (optional - depends on your business logic)
                        // For now, we'll create an offline customer record
                        $offlineCustomer = OfflineCustomer::create([
                            'cust_id' => 'CUST-' . time() . rand(1000, 9999),
                            'name' => $customerName,
                            'email' => $request->customer_email ?? null,
                            'phone' => $request->customer_phone ?? null,
                            'address' => $request->customer_address ?? null,
                            'city' => $request->city ?? null,
                            'pincode' => $request->pincode ?? null,
                            'gstin' => $request->customer_gstin ?? null,
                            'type' => 'online' // Mark as online type
                        ]);
                        
                        $userId = $offlineCustomer->cust_id;
                    }
                } else {
                    // Handle offline customer
                    $offlineCustomer = OfflineCustomer::where('name', $customerName)->first();
                    
                    if ($offlineCustomer) {
                        // Update existing offline customer details
                        $updateData = [];
                        if ($request->filled('customer_email')) {
                            $updateData['email'] = $request->customer_email;
                        }
                        if ($request->filled('customer_phone')) {
                            $updateData['phone'] = $request->customer_phone;
                        }
                        if ($request->filled('customer_address')) {
                            $updateData['address'] = $request->customer_address;
                        }
                        if ($request->filled('city')) {
                            $updateData['city'] = $request->city;
                        }
                        if ($request->filled('pincode')) {
                            $updateData['pincode'] = $request->pincode;
                        }
                        if ($request->filled('customer_gstin')) {
                            $updateData['gstin'] = $request->customer_gstin;
                        }
                        
                        if (!empty($updateData)) {
                            $offlineCustomer->update($updateData);
                        }
                        
                        $userId = $offlineCustomer->cust_id;
                    } else {
                        // Create new offline customer
                        $offlineCustomer = OfflineCustomer::create([
                            'cust_id' => 'CUST-' . time() . rand(1000, 9999),
                            'name' => $customerName,
                            'email' => $request->customer_email ?? null,
                            'phone' => $request->customer_phone ?? null,
                            'address' => $request->customer_address ?? null,
                            'city' => $request->city ?? null,
                            'pincode' => $request->pincode ?? null,
                            'gstin' => $request->customer_gstin ?? null,
                            'type' => 'offline'
                        ]);
                        
                        $userId = $offlineCustomer->cust_id;
                    }
                }
    
                // Final fallback - if still no user_id, generate one
                if (!$userId) {
                    $userId = 'USER-' . time() . rand(1000, 9999);
                }
    
                $performaNumber = $request->performa_number;
    
                $subTotal = 0;
                $totalDiscount = 0;
                $totalCgst = 0;
                $totalSgst = 0;
    
                // Calculate totals from items
                foreach ($request->items as $itemData) {
                    $qty = $itemData['quantity'];
                    $rate = $itemData['rate'];
                    $discountPercentage = $itemData['discount'] ?? 0;
                    
                    $amountBeforeDiscount = $qty * $rate;
                    $discountAmount = $amountBeforeDiscount * ($discountPercentage / 100);
                    $amountAfterDiscount = $amountBeforeDiscount - $discountAmount;
                    
                    $subTotal += $amountAfterDiscount;
                    $totalDiscount += $discountAmount;
    
                    if (!empty($itemData['tax_group_id'])) {
                        $taxGroup = TaxGroup::with('taxes')->find($itemData['tax_group_id']);
                        if ($taxGroup && $taxGroup->taxes->isNotEmpty()) {
                            $taxRates = $taxGroup->taxes->pluck('rate')->toArray();
                            
                            if (count($taxRates) >= 2) {
                                $cgstAmount = $amountAfterDiscount * ($taxRates[0] / 100);
                                $sgstAmount = $amountAfterDiscount * ($taxRates[1] / 100);
                                
                                $totalCgst += $cgstAmount;
                                $totalSgst += $sgstAmount;
                            } elseif (count($taxRates) === 1) {
                                $cgstAmount = $amountAfterDiscount * ($taxRates[0] / 200);
                                $sgstAmount = $amountAfterDiscount * ($taxRates[0] / 200);
                                
                                $totalCgst += $cgstAmount;
                                $totalSgst += $sgstAmount;
                            }
                        }
                    }
                }
    
                $grandTotal = $subTotal + $totalCgst + $totalSgst;
                $dueAmount = max(0, $grandTotal - $request->paid_amount);
    
                // Create Performa Invoice
                $performaInvoice = PerformaInvoice::create([
                    'user_id' => $userId,
                    'offline_online' => $request->offline_online,
                    'customer_name' => $customerName,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'customer_address' => $request->customer_address ?? '',
                    'city' => $request->city ?? '',
                    'pincode' => $request->pincode ?? '',
                    'customer_gstin' => $request->customer_gstin ?? '',
                    'admin_gstin' => $request->admin_gstin ?? '',
                    'performa_number' => $performaNumber,
                    'order_number' => $request->order_number,
                    'performa_date' => $request->performa_date,
                    'paid_amount' => $request->paid_amount,
                    'subtotal' => $subTotal,
                    'total_discount' => $totalDiscount,
                    'total_cgst' => $totalCgst,
                    'total_sgst' => $totalSgst,
                    'total' => $grandTotal,
                    'due_amount' => $dueAmount,
                ]);
    
                // Create Performa Invoice Items
                foreach ($request->items as $itemData) {
                    $product = Product::find($itemData['item_id']);
                    
                    if (!$product) continue;
    
                    $categoryName = 'No Category';
                    if ($product->category) {
                        if (is_object($product->category)) {
                            $categoryName = $product->category->name;
                        } else {
                            $category = Category::find($product->category);
                            $categoryName = $category ? $category->name : 'No Category';
                        }
                    }
    
                    $qty = $itemData['quantity'];
                    $rate = $itemData['rate'];
                    $discountPercentage = $itemData['discount'] ?? 0;
                    
                    $amountBeforeDiscount = $qty * $rate;
                    $discountAmount = $amountBeforeDiscount * ($discountPercentage / 100);
                    $amountAfterDiscount = $amountBeforeDiscount - $discountAmount;
    
                    $cgstAmount = 0;
                    $sgstAmount = 0;
                    $taxIds = [];
    
                    if (!empty($itemData['tax_group_id'])) {
                        $taxGroup = TaxGroup::with('taxes')->find($itemData['tax_group_id']);
                        if ($taxGroup && $taxGroup->taxes->isNotEmpty()) {
                            $taxRates = $taxGroup->taxes->pluck('rate')->toArray();
                            $taxIds = $taxGroup->taxes->pluck('id')->toArray();
                            
                            if (count($taxRates) >= 2) {
                                $cgstAmount = $amountAfterDiscount * ($taxRates[0] / 100);
                                $sgstAmount = $amountAfterDiscount * ($taxRates[1] / 100);
                            } elseif (count($taxRates) === 1) {
                                $cgstAmount = $amountAfterDiscount * ($taxRates[0] / 200);
                                $sgstAmount = $amountAfterDiscount * ($taxRates[0] / 200);
                            }
                        }
                    }
    
                    $finalAmount = $amountAfterDiscount + $cgstAmount + $sgstAmount;
    
                    PerformaInvoiceItem::create([
                        'performa_invoice_id' => $performaInvoice->id,
                        // 'item_id' => $product->id,
                        'item_name' => $product->productName,
                        'category' => $categoryName,
                        'quantity' => $qty,
                        'rate' => $rate,
                        'discount' => $discountPercentage,
                        'tax_group_id' => $itemData['tax_group_id'] ?? null,
                        'taxes' => !empty($taxIds) ? json_encode($taxIds) : null,
                        'eligible_for_itc' => $itemData['eligible_for_itc'] ?? false,
                        'amount' => $finalAmount,
                    ]);
                }
            });
    
            return redirect()->route('performa_invoices.index')->with('success', 'Performa Invoice created successfully.');
    
        } catch (\Exception $e) {
            Log::error('Performa Invoice creation failed: ' . $e->getMessage());
            Log::error('Request data: ', $request->all());
            return back()->with('error', 'Failed to create performa invoice: ' . $e->getMessage())->withInput();
        }
    }
    

    // Show Performa Invoice
    public function show($id)
    {
        $performaInvoice = PerformaInvoice::with('items')->findOrFail($id);
        return view('admin.PerformaInvoice.bill', compact('performaInvoice'));
    }

    // Download PDF
    public function download($id)
    {
        $performaInvoice = PerformaInvoice::with('items')->findOrFail($id);
        $pdf = Pdf::loadView('admin.PerformaInvoice.show', compact('performaInvoice'));
        return $pdf->download('PerformaInvoice-' . $performaInvoice->performa_number . '.pdf');
    }
    
    public function edit(PerformaInvoice $performaInvoice)
    {
        $customers = OfflineCustomer::all();
        $users = \App\Models\User::all(); // Add this line for online customers
        $items = Product::with('category')->get();
        $tax_groups = TaxGroup::with('taxes')->get();
    
        $performaInvoice->load('items');
    
        return view('admin.PerformaInvoice.edit', compact('performaInvoice', 'customers', 'users', 'items', 'tax_groups'));
    }

    // Update Performa Invoice
    public function update(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            try {
                $performaInvoice = PerformaInvoice::findOrFail($id);
    
                $validated = $request->validate([
                    'customer_name' => 'required|string|max:255',
                    'order_number' => 'nullable|string|max:255',
                    'performa_date' => 'required|date',
                    'paid_amount' => 'required|numeric|min:0',
                    'offline_online' => 'required|in:online,offline',
                    'customer_address' => 'nullable|string',
                    'customer_gstin' => 'nullable|string|max:20',
                    'admin_gstin' => 'nullable|string|max:20',
                    'performa_number' => 'required|string|max:255',
                    'items' => 'required|array|min:1',
                    'items.*.item_id' => 'required|exists:products,id',
                    'items.*.quantity' => 'required|numeric|min:0.01',
                    'items.*.discount' => 'nullable|numeric|min:0|max:100',
                    'items.*.tax_group_id' => 'required|exists:tax_groups,id',
                    'items.*.hsn' => 'required|string|max:20',
                    'items.*.rate' => 'required|numeric|min:0',
                    'items.*.cgst_amount' => 'required|numeric|min:0',
                    'items.*.sgst_amount' => 'required|numeric|min:0',
                    'items.*.cgst_rate' => 'required|numeric|min:0',
                    'items.*.sgst_rate' => 'required|numeric|min:0',
                    'items.*.taxable_amount' => 'required|numeric|min:0',
                    'items.*.amount' => 'required|numeric|min:0',
                    'items.*.eligible_for_itc' => 'nullable|boolean',
                ]);
    
                // Update the performa invoice
                $performaInvoice->update([
                    'customer_name' => $validated['customer_name'],
                    'order_number' => $validated['order_number'] ?? null,
                    'performa_date' => $validated['performa_date'],
                    'paid_amount' => $validated['paid_amount'],
                    'offline_online' => $validated['offline_online'],
                    'customer_address' => $validated['customer_address'] ?? null,
                    'customer_gstin' => $validated['customer_gstin'] ?? null,
                    'admin_gstin' => $validated['admin_gstin'] ?? null,
                    'performa_number' => $validated['performa_number'],
                ]);
    
                // Delete existing items
                $performaInvoice->items()->delete();
    
                $subtotal = 0;
                $totalCgst = 0;
                $totalSgst = 0;
                $totalTaxable = 0;
    
                foreach ($request->items as $itemData) {
                    $product = Product::find($itemData['item_id']);
    
                    $taxIds = [];
                    if (!empty($itemData['tax_group_id'])) {
                        $taxGroup = TaxGroup::with('taxes')->find($itemData['tax_group_id']);
                        if ($taxGroup) {
                            $taxIds = $taxGroup->taxes->pluck('id')->toArray();
                        }
                    }
    
                    // Create the performa invoice item
                    $item = new PerformaInvoiceItem([
                        'item_id' => $itemData['item_id'], // Make sure this field exists in your table
                        'item_name' => $product->productName,
                        'category' => $itemData['category'] ?? 'No Category',
                        'quantity' => $itemData['quantity'],
                        'rate' => $itemData['rate'],
                        'discount' => $itemData['discount'] ?? 0,
                        'tax_group_id' => $itemData['tax_group_id'],
                        'taxes' => !empty($taxIds) ? json_encode($taxIds) : null,
                        'hsn' => $itemData['hsn'] ?? null,
                        'cgst_amount' => $itemData['cgst_amount'] ?? 0,
                        'sgst_amount' => $itemData['sgst_amount'] ?? 0,
                        'cgst_rate' => $itemData['cgst_rate'] ?? 0,
                        'sgst_rate' => $itemData['sgst_rate'] ?? 0,
                        'taxable_amount' => $itemData['taxable_amount'] ?? 0,
                        'eligible_for_itc' => $itemData['eligible_for_itc'] ?? false,
                        'amount' => $itemData['amount'],
                    ]);
    
                    $performaInvoice->items()->save($item);
    
                    // Update totals
                    $totalTaxable += $itemData['taxable_amount'] ?? 0;
                    $subtotal += ($itemData['quantity'] * $itemData['rate']);
                    $totalCgst += $itemData['cgst_amount'] ?? 0;
                    $totalSgst += $itemData['sgst_amount'] ?? 0;
                }
    
                $totalDiscount = $subtotal - $totalTaxable;
                $grandTotal = $totalTaxable + $totalCgst + $totalSgst;
                $dueAmount = $grandTotal - $validated['paid_amount'];
    
                $performaInvoice->update([
                    'subtotal' => $subtotal,
                    'total_discount' => $totalDiscount,
                    'total_cgst' => $totalCgst,
                    'total_sgst' => $totalSgst,
                    'total' => $grandTotal,
                    'due_amount' => $dueAmount > 0 ? $dueAmount : 0,
                ]);
    
                DB::commit();
    
                return redirect()->route('performa_invoices.index')
                    ->with('success', 'Performa Invoice updated successfully.');
    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Performa Invoice update failed: ' . $e->getMessage());
                Log::error('Request data: ', $request->all());
    
                return back()->with('error', 'Error updating performa invoice: ' . $e->getMessage())
                    ->withInput();
            }
        });
    }
    
    // Delete Performa Invoice
    public function destroy(PerformaInvoice $performaInvoice)
    {
        try {
            $performaInvoice->delete();
            return redirect()->route('performa_invoices.index')->with('success', 'Performa Invoice deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Performa Invoice deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Error deleting performa invoice: ' . $e->getMessage());
        }
    }
 
}
