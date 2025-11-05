<?php

namespace App\Http\Controllers;

use App\Models\OfflineCustomer;
use App\Models\Product;
use App\Models\TaxGroup;
use App\Models\Category;
use App\Models\Prouduct;
use App\Models\User;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tax;

class InvoiceController extends Controller
{

public function generateInvoice($orderId, Request $request)
{
    try {
        DB::beginTransaction();

        $orderData = $request->input('order');
        if (!$orderData) {
            return response()->json(['error' => 'Order data not provided'], 400);
        }

        // ✅ Check if invoice already exists
        $existingInvoice = Invoice::where('order_number', $orderId)->first();
        if ($existingInvoice) {
            return response()->json([
                'success' => true,
                'invoice_id' => $existingInvoice->id,
                'invoice_number' => $existingInvoice->invoice_number,
                'message' => 'Invoice already exists for this order'
            ]);
        }

        // ✅ Generate next invoice number
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $nextNumber = $lastInvoice
            ? ((int) str_replace("INV-", "", $lastInvoice->invoice_number)) + 1
            : 1;
        $invoiceNumber = "INV-" . str_pad($nextNumber, 5, "0", STR_PAD_LEFT);

        // ✅ Customer Address
        $customerAddress = isset($orderData['shipping_address'])
            ? $orderData['shipping_address']['address'] . ', ' .
              $orderData['shipping_address']['city'] . ', ' .
              $orderData['shipping_address']['state'] . ' - ' .
              $orderData['shipping_address']['pincode']
            : '';

        // ✅ Create Customer Id
        $custId = 'CUSTID-' . \Illuminate\Support\Str::random(7);

        // ✅ Create Invoice
        $invoice = Invoice::create([
            'user_id' => $custId,
            'offline_online' => 'Online',
            'customer_name' => $orderData['customer_name'],
            'invoice_number' => $invoiceNumber,
            'order_number' => $orderId,
            'invoice_date' => now(),
            'paid_amount' => $orderData['order_total'],
            'total' => $orderData['order_total'],
            'due_amount' => 0,
            'customer_address' => $customerAddress,
            'customer_gstin' => '',
            'admin_gstin' => '',
        ]);

        // ✅ Create Invoice Items with taxes
                if (isset($orderData['order_items']) && is_array($orderData['order_items'])) {
                foreach ($orderData['order_items'] as $item) {
                    $quantity = $item['quantity'] ?? 1;
                    $grossRate = $item['price'] ?? 0; // Inclusive rate (with tax)

                    $product = Product::where('productName', $item['name'])->first();
                    $taxGroupId = $product->tax_rate ?? ''; // tax_group_id


                    // ✅ Fetch taxes from tax_group_tax
                    $taxes = DB::table('tax_group_tax')
                        ->join('taxes', 'tax_group_tax.tax_id', '=', 'taxes.id')
                        ->where('tax_group_tax.tax_group_id', $taxGroupId)
                        ->select('taxes.id','taxes.name','taxes.rate','taxes.tax_group')
                        ->get();

                    // ✅ Total tax %
                    $totalTaxRate = $taxes->sum('rate');

                    // ✅ Net rate (subtract tax)
                    $netRate = $grossRate;
                    if ($totalTaxRate > 0) {
                        $netRate = $grossRate / (1 + ($totalTaxRate / 100));
                    }

                    // ✅ Tax breakdown
                    $taxArray = [];
                    foreach ($taxes as $tax) {
                        $taxAmount = $netRate * ($tax->rate / 100);
                        $taxArray[] = [
                            'id'    => $tax->id,
                        ];
                    }

                    $category = Category::where('name',$product->category)->first();

                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'item_name'  => $item['name'] ?? 'Unknown Product',
                        'category'   => $category->id,
                        'quantity'   => $quantity,
                        'rate'       => round($netRate, 2), // ✅ base rate without tax
                        'discount'   => 0,
                        'taxes'      => json_encode($taxArray) ?? '',
                        'eligible_for_itc' => false,
                        'amount'     => round($item['price'] * $quantity, 2), // ✅ net amount
                    ]);
                }
            }


        DB::commit();

        return response()->json([
            'success' => true,
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoiceNumber,
            'message' => 'Invoice created successfully'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to create invoice: ' . $e->getMessage()], 500);
    }
}


    private function getOrderData($orderId)
    {
        // Replace this with your actual logic to fetch order data
        // This is just a placeholder - adapt to your data structure
        foreach ($shiprocketOrders as $order) {
            if ($order['order_id'] == $orderId) {
                return $order;
            }
        }
        return null;
    }


    public function create()
    {
        // $customers = \App\Models\User::all();
        $customers = OfflineCustomer::all();
        $items       = \App\Models\Product::with('category')->get();
          $tax_groups   = TaxGroup::with('taxes')->get(); // ✅ ye le aayega groups + unke taxes
         $lastInvoice = Invoice::latest('id')->first();
         $categories = Category::all();
        $nextNumber = $lastInvoice
        ? 'INV-' . str_pad(((int) substr($lastInvoice->invoice_number, 4)) + 1, 5, '0', STR_PAD_LEFT)
        : 'INV-00001';

        return view('admin.invoices.invoice.create', compact('customers','items','tax_groups','nextNumber','categories'));
    }




            // public function store(Request $request)
            // {
            //     // Validate request data
            //     $request->validate([
            //         'customer_name'   => 'required|string|max:255',
            //         'invoice_date'    => 'required|date',
            //         'paid_amount'     => 'required|numeric|min:0',
            //         'items'           => 'required|array|min:1',
            //         'items.*.item_id' => 'required|exists:products,id',
            //         'items.*.quantity' => 'required|numeric|min:1',
            //         'items.*.rate'     => 'required|numeric|min:0',
            //         'items.*.discount' => 'nullable|numeric|min:0|max:100',
            //         'items.*.tax_group_id' => 'nullable|exists:tax_groups,id',
            //         'items.*.size'     => 'nullable|string', // Add size for variants
            //         'customer_gstin'  => 'nullable|string|max:15',
            //         'admin_gstin'     => 'nullable|string|max:15',
            //         'customer_email'  => 'nullable|email|max:255',
            //         'customer_phone'  => 'nullable|string|max:20',
            //         'customer_address' => 'nullable|string',
            //         'city'            => 'nullable|string|max:100',
            //         'pincode'         => 'nullable|string|max:10',
            //         'order_number'    => 'nullable|string|max:50',
            //         'scanned_barcodes' => 'nullable|string',
            //     ]);
            
            //     try {
            //         // Determine userId and store customer details in OfflineCustomer
            //         $userId = null;
            //         $customerAddress = $request->customer_address;
            
            //         // Check for existing offline customer by name
            //         $offlineCustomer = \App\Models\OfflineCustomer::where('name', $request->customer_name)->first();
            
            //         if ($offlineCustomer) {
            //             $userId = $offlineCustomer->cust_id;
            //             // Update existing customer with new details
            //             $offlineCustomer->update([
            //                 'email' => $request->customer_email ?? $offlineCustomer->email,
            //                 'phone' => $request->customer_phone ?? $offlineCustomer->phone,
            //                 'address' => $request->customer_address ?? $offlineCustomer->address,
            //                 'city' => $request->city ?? $offlineCustomer->city,
            //                 'pincode' => $request->pincode ?? $offlineCustomer->pincode,
            //                 'gstin' => $request->customer_gstin ?? $offlineCustomer->gstin,
            //             ]);
            //         } else {
            //             // Store new offline customer with a unique cust_id
            //             $custId = 'CUSTID-' . \Illuminate\Support\Str::random(7);
            //             \App\Models\OfflineCustomer::create([
            //                 'cust_id' => $custId,
            //                 'name' => $request->customer_name,
            //                 'email' => $request->customer_email,
            //                 'phone' => $request->customer_phone,
            //                 'address' => $request->customer_address,
            //                 'city' => $request->city,
            //                 'pincode' => $request->pincode,
            //                 'gstin' => $request->customer_gstin,
            //             ]);
            //             $userId = $custId; // Use the generated cust_id
            //         }
            
            //         // Invoice number
            //         $invoiceNumber = $request->invoice_number ?? 'INV-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(6));
            
            //         // Calculate totals
            //         $subTotal = 0;
            //         $taxTotal = 0;
            
            //         foreach ($request->items as $itemData) {
            //             $qty = (float) ($itemData['quantity'] ?? 1);
            //             $rate = (float) ($itemData['rate'] ?? 0);
            //             $disc = (float) ($itemData['discount'] ?? 0);
            
            //             // Base amount
            //             $amountBeforeDiscount = $qty * $rate;
            
            //             // Discount
            //             $discountAmount = $amountBeforeDiscount * ($disc / 100);
            //             $finalAmount = $amountBeforeDiscount - $discountAmount;
            
            //             $subTotal += $finalAmount;
            
            //             // Handle taxes
            //             $groupId = $itemData['tax_group_id'] ?? null;
            //             $taxes = collect();
            
            //             if ($groupId) {
            //                 $group = \App\Models\TaxGroup::find($groupId);
            //                 if ($group) {
            //                     $taxes = $group->taxes;
            //                 } else {
            //                     \Illuminate\Support\Facades\Log::warning("Tax group ID {$groupId} not found for item {$itemData['item_id']}");
            //                 }
            //             }
            
            //             foreach ($taxes as $tax) {
            //                 $taxTotal += ($finalAmount * $tax->rate) / 100;
            //             }
            //         }
            
            //         $grandTotal = $subTotal + $taxTotal;
            
            //         // Calculate due amount
            //         $paidAmount = (float) $request->paid_amount;
            //         $dueAmount = max(0, $grandTotal - $paidAmount);
            
            //         // Store new offline customer with a unique cust_id
            //         $custId = 'CUSTID-' . \Illuminate\Support\Str::random(7);
                    
            //         // Store invoice
            //         $invoice = \App\Models\Invoice::create([
            //             'user_id'          => $custId,
            //             'offline_online'   => 'Offline',
            //             'customer_name'    => $request->customer_name,
            //             'customer_address' => $customerAddress,
            //             'customer_gstin'   => $request->customer_gstin,
            //             'admin_gstin'      => $request->admin_gstin,
            //             'invoice_number'   => $invoiceNumber,
            //             'order_number'     => $request->order_number,
            //             'invoice_date'     => $request->invoice_date,
            //             'paid_amount'      => $paidAmount,
            //             'sub_total'        => $subTotal,
            //             'tax_total'        => $taxTotal,
            //             'total'            => $grandTotal,
            //             'due_amount'       => $dueAmount,
            //         ]);
            
            //         // Process scanned barcodes and update stock
            //         $scannedBarcodes = $request->scanned_barcodes ? explode(',', $request->scanned_barcodes) : [];
                    
            //         // Group barcodes by product for efficient processing
            //         $barcodeCounts = array_count_values($scannedBarcodes);
                    
            //         // Process items and update stock
            //         foreach ($request->items as $itemData) {
            //             $qty = (float) ($itemData['quantity'] ?? 1);
            //             $rate = (float) ($itemData['rate'] ?? 0);
            //             $disc = (float) ($itemData['discount'] ?? 0);
            //             $productId = $itemData['item_id'];
            //             $size = $itemData['size'] ?? null;
            
            //             $amountBeforeDiscount = $qty * $rate;
            //             $discountAmount = $amountBeforeDiscount * ($disc / 100);
            //             $finalAmount = $amountBeforeDiscount - $discountAmount;
            
            //             // Fetch item details
            //             $item = \App\Models\Product::with(['category', 'variants'])->find($productId);
            
            //             $itemName = $item ? $item->productName : 'Unnamed Item';
            //             $categoryName = Category::find($item->category);
            
            //             // Get tax IDs for storage
            //             $groupId = $itemData['tax_group_id'] ?? null;
            //             $taxIds = [];
            //             if ($groupId) {
            //                 $group = \App\Models\TaxGroup::find($groupId);
            //                 if ($group) {
            //                     $taxIds = $group->taxes->pluck('id')->toArray();
            //                 }
            //             }
            
            //             $invoice->items()->create([
            //                 'item_name'        => $itemName,
            //                 'category'         => $categoryName->id,
            //                 'quantity'         => $qty,
            //                 'rate'             => $rate,
            //                 'discount'         => $disc,
            //                 'taxes'            => json_encode($taxIds),
            //                 'eligible_for_itc' => isset($itemData['eligible_for_itc']) ? 1 : 0,
            //                 'amount'           => $finalAmount,
            //             ]);
            
            //             // Update product stock based on product type
            //           // Update product stock based on product type
            //             if ($item) {
            //                 // Handle stock reduction based on product type
            //                 if ($item->product_type === 'variant' && $size) {
            //                     // For variant products, update stock in ProductVariant
            //                     $variant = ProductVariant::where('product_id', $productId)
            //                                             ->where('size', $size)
            //                                             ->first();
                                
            //                     if ($variant) {
            //                         // Decrement variant stock
            //                         $variant->decrement('stock', $qty);
                                    
            //                         // Also update main product stock if needed
            //                         $item->decrement('current_stock', $qty);
                                    
            //                         if (isset($item->total_stock)) {
            //                             $item->decrement('total_stock', $qty);
            //                         }
                                    
            //                         \Illuminate\Support\Facades\Log::info("Reduced stock for variant: Product ID {$productId}, Size: {$size}, Quantity: {$qty}");
            //                     } else {
            //                         \Illuminate\Support\Facades\Log::warning("Variant not found for Product ID {$productId} with size: {$size}");
            //                     }
            //                 } else {
            //                     // For simple products, update stock in main product table
            //                     $item->decrement('current_stock', $qty);
                                
            //                     if (isset($item->total_stock)) {
            //                         $item->decrement('total_stock', $qty);
            //                     }
                                
            //                     \Illuminate\Support\Facades\Log::info("Reduced stock for simple product: Product ID {$productId}, Quantity: {$qty}");
            //                 }
            
            //                 // Handle QR codes deletion for both product types
            //                 $qtyToDelete = min($qty, count($scannedBarcodes));
                            
            //                 if ($qtyToDelete > 0) {
            //                     $barcodesToDelete = [];
                                
            //                     foreach ($scannedBarcodes as $index => $barcode) {
            //                         if (count($barcodesToDelete) >= $qtyToDelete) {
            //                             break;
            //                         }
                                    
            //                         // Check if this barcode belongs to the current product
            //                         $productIdentifier = \App\Models\ProductIdentifier::where('qr_code', $barcode)
            //                             ->where('product_id', $productId)
            //                             ->first();
                                        
            //                         if ($productIdentifier) {
            //                             $barcodesToDelete[] = $barcode;
            //                             // Remove from scanned barcodes array
            //                             unset($scannedBarcodes[$index]);
            //                         }
            //                     }
                                
            //                     // Delete the QR codes
            //                     if (!empty($barcodesToDelete)) {
            //                         \App\Models\ProductIdentifier::whereIn('qr_code', $barcodesToDelete)
            //                             ->where('product_id', $productId)
            //                             ->delete();
            //                     }
            //                 }
            //             }
            //         }
            
            //         return redirect()->back()->with('success', 'Invoice created successfully!');
            //     } catch (\Illuminate\Validation\ValidationException $e) {
            //         \Illuminate\Support\Facades\Log::error('Validation failed: ' . json_encode($e->errors()));
            //         return redirect()->back()->withErrors($e->errors())->withInput();
            //     } catch (\Exception $e) {
            //         \Illuminate\Support\Facades\Log::error('Invoice creation failed: ' . $e->getMessage());
            //         return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage())->withInput();
            //     }
            // }


            public function store(Request $request)
{
    // Validate request data
    $request->validate([
        'customer_name'   => 'required|string|max:255',
        'invoice_date'    => 'required|date',
        'paid_amount'     => 'required|numeric|min:0',
        'items'           => 'required|array|min:1',
        'items.*.item_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.rate'     => 'required|numeric|min:0',
        'items.*.discount' => 'nullable|numeric|min:0|max:100',
        'items.*.tax_group_id' => 'nullable|exists:tax_groups,id',
        'items.*.size'     => 'nullable|string', // Add size for variants
        'customer_gstin'  => 'nullable|string|max:15',
        'admin_gstin'     => 'nullable|string|max:15',
        'customer_email'  => 'nullable|email|max:255',
        'customer_phone'  => 'nullable|string|max:20',
        'customer_address' => 'nullable|string',
        'city'            => 'nullable|string|max:100',
        'pincode'         => 'nullable|string|max:10',
        'order_number'    => 'nullable|string|max:50',
        'scanned_barcodes' => 'nullable|string',
    ]);

    try {
        // Determine userId and store customer details in OfflineCustomer
        $userId = null;
        $customerAddress = $request->customer_address;

        // Check for existing offline customer by name
        $offlineCustomer = \App\Models\OfflineCustomer::where('name', $request->customer_name)->first();

        if ($offlineCustomer) {
            $userId = $offlineCustomer->cust_id;
            // Update existing customer with new details
            $offlineCustomer->update([
                'email' => $request->customer_email ?? $offlineCustomer->email,
                'phone' => $request->customer_phone ?? $offlineCustomer->phone,
                'address' => $request->customer_address ?? $offlineCustomer->address,
                'city' => $request->city ?? $offlineCustomer->city,
                'pincode' => $request->pincode ?? $offlineCustomer->pincode,
                'gstin' => $request->customer_gstin ?? $offlineCustomer->gstin,
            ]);
        } else {
            // Store new offline customer with a unique cust_id
            $custId = 'CUSTID-' . \Illuminate\Support\Str::random(7);
            \App\Models\OfflineCustomer::create([
                'cust_id' => $custId,
                'name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
                'address' => $request->customer_address,
                'city' => $request->city,
                'pincode' => $request->pincode,
                'gstin' => $request->customer_gstin,
            ]);
            $userId = $custId; // Use the generated cust_id
        }

        // Invoice number
        $invoiceNumber = $request->invoice_number ?? 'INV-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(6));

        // Calculate totals
        $subTotal = 0;
        $taxTotal = 0;

        foreach ($request->items as $itemData) {
            $qty = (float) ($itemData['quantity'] ?? 1);
            $rate = (float) ($itemData['rate'] ?? 0);
            $disc = (float) ($itemData['discount'] ?? 0);

            // Base amount
            $amountBeforeDiscount = $qty * $rate;

            // Discount
            $discountAmount = $amountBeforeDiscount * ($disc / 100);
            $finalAmount = $amountBeforeDiscount - $discountAmount;

            $subTotal += $finalAmount;

            // Handle taxes
            $groupId = $itemData['tax_group_id'] ?? null;
            $taxes = collect();

            if ($groupId) {
                $group = \App\Models\TaxGroup::find($groupId);
                if ($group) {
                    $taxes = $group->taxes;
                } else {
                    \Illuminate\Support\Facades\Log::warning("Tax group ID {$groupId} not found for item {$itemData['item_id']}");
                }
            }

            foreach ($taxes as $tax) {
                $taxTotal += ($finalAmount * $tax->rate) / 100;
            }
        }

        $grandTotal = $subTotal + $taxTotal;

        // Calculate due amount
        $paidAmount = (float) $request->paid_amount;
        $dueAmount = max(0, $grandTotal - $paidAmount);

        // Create new invoice
        $custId = 'CUSTID-' . \Illuminate\Support\Str::random(7);
        $invoice = \App\Models\Invoice::create([
            'user_id'          => $custId,
            'offline_online'   => 'Offline',
            'customer_name'    => $request->customer_name,
            'customer_address' => $customerAddress,
            'customer_gstin'   => $request->customer_gstin,
            'admin_gstin'      => $request->admin_gstin,
            'invoice_number'   => $invoiceNumber,
            'order_number'     => $request->order_number,
            'invoice_date'     => $request->invoice_date,
            'paid_amount'      => $paidAmount,
            'sub_total'        => $subTotal,
            'tax_total'        => $taxTotal,
            'total'            => $grandTotal,
            'due_amount'       => $dueAmount,
        ]);

        // Process scanned barcodes
        $scannedBarcodes = $request->scanned_barcodes ? explode(',', $request->scanned_barcodes) : [];
        $barcodeCounts = array_count_values($scannedBarcodes);

        // Process items and update stock
        foreach ($request->items as $itemData) {
            $qty = (float) ($itemData['quantity'] ?? 1);
            $rate = (float) ($itemData['rate'] ?? 0);
            $disc = (float) ($itemData['discount'] ?? 0);
            $productId = $itemData['item_id'];
            $size = $itemData['size'] ?? null;

            $amountBeforeDiscount = $qty * $rate;
            $discountAmount = $amountBeforeDiscount * ($disc / 100);
            $finalAmount = $amountBeforeDiscount - $discountAmount;

            $item = \App\Models\Product::with(['category', 'variants'])->find($productId);
            $itemName = $item ? $item->productName : 'Unnamed Item';
            $categoryName = \App\Models\Category::find($item->category);

            // Get tax IDs
            $groupId = $itemData['tax_group_id'] ?? null;
            $taxIds = [];
            if ($groupId) {
                $group = \App\Models\TaxGroup::find($groupId);
                if ($group) {
                    $taxIds = $group->taxes->pluck('id')->toArray();
                }
            }

            // Save invoice item
            $invoice->items()->create([
                'item_name'        => $itemName,
                'category'         => $categoryName->id ?? null,
                'quantity'         => $qty,
                'rate'             => $rate,
                'discount'         => $disc,
                'taxes'            => json_encode($taxIds),
                'eligible_for_itc' => isset($itemData['eligible_for_itc']) ? 1 : 0,
                'amount'           => $finalAmount,
            ]);

            // ✅ Stock update logic (Fixed & Simplified)
            if ($item) {
                if ($item->product_type === 'variant' && $size) {
                    $variant = \App\Models\ProductVariant::where('product_id', $productId)
                        ->where('size', $size)
                        ->first();

                    if ($variant) {
                        // Decrease variant stock
                        $variant->stock = max(0, $variant->stock - $qty);
                        $variant->save();

                        // Decrease product stock
                        $item->current_stock = max(0, $item->current_stock - $qty);
                        if (isset($item->total_stock)) {
                            $item->total_stock = max(0, $item->total_stock - $qty);
                        }
                        $item->save();

                        Log::info("Stock decreased for VARIANT: Product {$productId}, Size {$size}, Qty {$qty}");
                    } else {
                        Log::warning("Variant not found for Product {$productId}, Size {$size}");
                    }
                } else {
                    // Simple product
                    $item->current_stock = max(0, $item->current_stock - $qty);
                    if (isset($item->total_stock)) {
                        $item->total_stock = max(0, $item->total_stock - $qty);
                    }
                    $item->save();

                    Log::info("Stock decreased for SIMPLE product: Product {$productId}, Qty {$qty}");
                }

                // Delete sold QR codes
                $qtyToDelete = min($qty, count($scannedBarcodes));
                if ($qtyToDelete > 0) {
                    $barcodesToDelete = [];
                    foreach ($scannedBarcodes as $index => $barcode) {
                        if (count($barcodesToDelete) >= $qtyToDelete) break;

                        $productIdentifier = \App\Models\ProductIdentifier::where('qr_code', $barcode)
                            ->where('product_id', $productId)
                            ->first();

                        if ($productIdentifier) {
                            $barcodesToDelete[] = $barcode;
                            unset($scannedBarcodes[$index]);
                        }
                    }

                    if (!empty($barcodesToDelete)) {
                        \App\Models\ProductIdentifier::whereIn('qr_code', $barcodesToDelete)
                            ->where('product_id', $productId)
                            ->delete();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Invoice created successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation failed: ' . json_encode($e->errors()));
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        Log::error('Invoice creation failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage())->withInput();
    }
}



      public function index(Request $request)
    {
        // Start query
        $query = Invoice::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->has('status') && !empty($request->status)) {
            switch ($request->status) {
                case 'paid':
                    $query->where('due_amount', 0);
                    break;
                case 'pending':
                    $query->where('due_amount', '>', 0)
                          ->whereDate('invoice_date', '>=', now()->subDays(30));
                    break;
                case 'overdue':
                    $query->where('due_amount', '>', 0)
                          ->whereDate('invoice_date', '<', now()->subDays(30));
                    break;
            }
        }

        // Apply date range filter
        if ($request->has('date_range') && !empty($request->date_range)) {
            switch ($request->date_range) {
                case 'week':
                    $query->whereBetween('invoice_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ]);
                    break;
                case 'month':
                    $query->whereBetween('invoice_date', [
                        now()->startOfMonth(),
                        now()->endOfMonth()
                    ]);
                    break;
                case 'quarter':
                    $query->whereBetween('invoice_date', [
                        now()->startOfQuarter(),
                        now()->endOfQuarter()
                    ]);
                    break;
                case 'year':
                    $query->whereBetween('invoice_date', [
                        now()->startOfYear(),
                        now()->endOfYear()
                    ]);
                    break;
            }
        }

        // Get filtered invoices with pagination
        $invoices = $query->orderBy('invoice_date', 'desc')->paginate(10);

        // Calculate statistics
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('due_amount', 0)->count();
        $pendingInvoices = Invoice::where('due_amount', '>', 0)
                                ->whereDate('invoice_date', '>=', now()->subDays(30))
                                ->count();
        $overdueInvoices = Invoice::where('due_amount', '>', 0)
                                ->whereDate('invoice_date', '<', now()->subDays(30))
                                ->count();

        return view('admin.invoices.invoice.index', compact(
            'invoices',
            'totalInvoices',
            'paidInvoices',
            'pendingInvoices',
            'overdueInvoices'
        ));
    }

    public function show_bill($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);

        return view('admin.invoices.invoice.bill', compact('invoice'));
    }



    public function download($id)
    {
        // Fetch invoice with items & taxes
        $invoice = Invoice::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('admin.invoices.invoice.bill', compact('invoice'));

        // download as Invoice.pdf
        return $pdf->download('Invoice-' . $invoice->invoice_number . '.pdf');
    }



    public function edit(Invoice $invoice)
    {
        $customers = OfflineCustomer::all();
        $items = Product::with('category')->get();
        $tax_groups = TaxGroup::with('taxes')->get();

        // Load invoice with item relations (category + tax group)
        $invoice->load(['items.product.category', 'items.taxGroup']);
            // Load the invoice with its items
        // $invoice->load('items');

        return view('admin.invoices.invoice.edit', compact('invoice', 'customers', 'items', 'tax_groups'));
    }



public function update(Request $request, $id)
{
    return DB::transaction(function () use ($request, $id) {
        try {
            $invoice = Invoice::findOrFail($id);

            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'order_number' => 'required|string|max:255',
                'invoice_date' => 'required|date',
                'paid_amount' => 'required|numeric|min:0',
                'customer_address' => 'nullable|string',
                'customer_gstin' => 'nullable|string|max:20',
                'invoice_number' => 'required|string|max:255',
                'items' => 'required|array|min:1',
                'items.*.item_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.discount' => 'nullable|numeric|min:0|max:100',
                'items.*.tax_group_id' => 'required|exists:tax_groups,id',
                'items.*.hsn' => 'nullable|string|max:20',
                'items.*.rate' => 'required|numeric|min:0',
                'items.*.cgst' => 'required|numeric|min:0',
                'items.*.igst' => 'required|numeric|min:0',
                'items.*.amount' => 'required|numeric|min:0',
            ]);

            // Update the invoice
            $invoice->update([
                'customer_name' => $validated['customer_name'],
                'order_number' => $validated['order_number'],
                'invoice_date' => $validated['invoice_date'],
                'paid_amount' => $validated['paid_amount'],
                'customer_address' => $validated['customer_address'] ?? null,
                'customer_gstin' => $validated['customer_gstin'] ?? null,
                'invoice_number' => $validated['invoice_number'],
            ]);

            // Delete existing items
            $invoice->items()->delete();

            $subtotal = 0;
            $totalCgst = 0;
            $totalIgst = 0;

            foreach ($request->items as $itemData) {
                $product = Product::find($itemData['item_id']);

                // Get tax group to extract tax IDs
                $taxGroup = TaxGroup::with('taxes')->find($itemData['tax_group_id']);

                // Extract tax IDs for CGST and IGST from the tax group
                $taxIds = [];
                foreach ($taxGroup->taxes as $tax) {
                    // Store both CGST and IGST tax IDs
                    $taxIds[] = $tax->id;
                }

                // Create the invoice item with tax IDs array
                $item = new InvoiceItem([
                    'item_id' => $itemData['item_id'],
                    'item_name' => $product->productName,
                    'category_id' => $itemData['category_id'],
                    'category' => $product->category,
                    'quantity' => $itemData['quantity'],
                    'rate' => $itemData['rate'],
                    'discount' => $itemData['discount'] ?? 0,
                    'tax_group_id' => $itemData['tax_group_id'],
                    'taxes' => $taxIds, // Store as array of tax IDs
                    'hsn' => $itemData['hsn'] ?? null,
                    'amount' => $itemData['amount'],
                ]);

                $invoice->items()->save($item);

                $subtotal += $itemData['amount'] - $itemData['cgst'] - $itemData['igst'];
                $totalCgst += $itemData['cgst'];
                $totalIgst += $itemData['igst'];
            }

            $total = $subtotal + $totalCgst + $totalIgst;
            $dueAmount = $total - $validated['paid_amount'];

            $invoice->update([
                'total' => $total,
                'due_amount' => $dueAmount > 0 ? $dueAmount : 0,
            ]);

            DB::commit();

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error updating invoice: ' . $e->getMessage())
                ->withInput();
        }
    });
}

public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
    }

}
