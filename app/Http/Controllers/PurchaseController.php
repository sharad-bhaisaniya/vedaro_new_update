<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Tax;
use App\Models\ProductVariant;
use App\Models\TaxGroup;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // ✅ Added for unique rule fix


class PurchaseController extends Controller
{

   public function index()
    {
        $purchases = Purchase::with(['items', 'vendor'])
            ->orderBy('created_at', 'desc')
            ->paginate(50); // Load only 50 records per page
        
        return view('admin.invoices.purchases.index', compact('purchases'));
    }
    public function create()
    {
        $vendors = Vendor::all();
        $tax_groups = TaxGroup::with('taxes')->get();
        $categories = Category::all();
        return view('admin.invoices.purchases.create', compact('vendors', 'tax_groups', 'categories'));
    }

    /**
     * Store a newly created purchase in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */


    


    public function store(Request $request)
    {
        try {
            Log::info('Purchase Store Request Data:', $request->all());

            $validator = Validator::make($request->all(), [
                'invoiceNumber' => 'required|string|max:255|unique:purchases,invoice_number',
                'invoiceDate' => 'required|date',
                'vendorName' => 'required|exists:vendors,id',
                'items' => 'required|array|min:1',
                'items.*.productName' => 'required|string|max:255',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unitPrice' => 'required|numeric|min:0',
                'items.*.discountPercentage' => 'nullable|numeric|min:0|max:100',
                'items.*.tax_group_id' => 'required|exists:tax_groups,id',
                'items.*.sellName' => 'required|string|max:255',
                'items.*.category' => 'required|string|max:255|exists:categories,name',
                'items.*.brand' => 'nullable|string|max:255',
                'items.*.barcode' => 'nullable|string|max:255',
                'items.*.hsnCode' => 'nullable|string|max:255',
                'items.*.mrpPerUnit' => 'nullable|numeric|min:0',
                'items.*.sellPrice' => 'nullable|numeric|min:0',
                'items.*.sellDiscountPercentage' => 'nullable|numeric|min:0|max:100',
                'items.*.shippingFee' => 'nullable|numeric|min:0',
                'items.*.sell_tax_group_id' => 'required|exists:tax_groups,id',
                'items.*.productDescription1' => 'nullable|string',
                'items.*.productDescription2' => 'nullable|string',
                'items.*.image1' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'items.*.image2' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'items.*.image3' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'items.*.variants' => 'nullable|array',
                'items.*.variants.*.size' => 'nullable|string|max:255',
                'items.*.variants.*.weight' => 'nullable|numeric|min:0',
                'items.*.variants.*.price' => 'nullable|numeric|min:0',
                'items.*.variants.*.stock' => 'nullable|numeric|min:0',
                'items.*.availability' => 'nullable|in:0,1',
                'items.*.on_sell' => 'nullable|in:0,1',
                'items.*.addTimer' => 'nullable|in:0,1',
                'items.*.timerDatetime' => 'nullable|date',
                'items.*.stock' => 'nullable|numeric|min:0',
            ]);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            $vendor = Vendor::findOrFail($request->vendorName);

            $purchase = Purchase::create([
                'invoice_number' => $request->invoiceNumber,
                'invoice_date' => $request->invoiceDate,
                'vendor_id' => $request->vendorName,
                'vendor_gstin' => $vendor->gst_no,
                'grand_total' => 0
            ]);

            $grandTotal = 0;

            foreach ($request->input('items') as $index => $itemData) {
                try {
                    Log::info("Processing item {$index}:", $itemData);

                    // Attach uploaded files
                    $itemData['image1'] = $request->file("items.{$index}.image1");
                    $itemData['image2'] = $request->file("items.{$index}.image2");
                    $itemData['image3'] = $request->file("items.{$index}.image3");

                    $quantity = (float)($itemData['quantity'] ?? 0);
                    $unitPrice = (float)($itemData['unitPrice'] ?? 0);
                    $discountPercentage = (float)($itemData['discountPercentage'] ?? 0);

                    $netPrice = $unitPrice * (1 - ($discountPercentage / 100));
                    $netAmount = $netPrice * $quantity;

                    $taxGroup = TaxGroup::with('taxes')->find($itemData['tax_group_id']);
                    if (!$taxGroup) throw new \Exception("Tax group not found for item: " . ($itemData['productName'] ?? 'Unknown'));

                    $taxRate = $taxGroup->taxes->sum('rate');
                    $taxAmount = $netAmount * ($taxRate / 100);
                    $totalInclTax = $netAmount + $taxAmount;

                    $grandTotal += $totalInclTax;

                    $purchaseItem = PurchaseItem::create([
                        'item_code' => $itemData['itemCode'] ?? null,
                        'purchase_id' => $purchase->id,
                        'product_name' => $itemData['productName'],
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'discount_percentage' => $discountPercentage,
                        'net_price' => $netPrice,
                        'tax_amount' => $taxAmount,
                        'total_incl_tax' => $totalInclTax,
                        'tax_group_id' => $itemData['tax_group_id'],
                    ]);

                    $this->createOrUpdateProduct($itemData, $purchaseItem);

                } catch (\Exception $e) {
                    Log::error("Error processing item {$index}: " . $e->getMessage());
                    throw new \Exception("Error processing item '" . ($itemData['productName'] ?? 'Unknown') . "': " . $e->getMessage());
                }
            }

            $purchase->update(['grand_total' => $grandTotal]);

            DB::commit();

       return response()->json([
        'success' => true,
        'type' => 'info', // 👈 add type field
        'message' => 'Purchase created successfully!',
        'redirect_url' => route('purchase.index'),
        ]);

            return redirect()
        ->route('purchases.index')
        ->with('info', 'Purchase created successfully!');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Purchase Store Error: ' . $e->getMessage());
                Log::error('Stack Trace: ' . $e->getTraceAsString());

                return response()->json([
                    'success' => false,
                    'message' => 'Error recording purchase: ' . $e->getMessage()
                ], 500);
            }
    }

   

   private function createOrUpdateProduct($itemData, $purchaseItem)
{
    try {
        Log::info('createOrUpdateProduct itemData:', $itemData);

        // Get or create product
        $product = Product::firstOrNew(['productName' => $itemData['sellName']]);

        $categoryId = Category::where('name', $itemData['category'])->value('id');
        if (!$categoryId) throw new \Exception("Category '{$itemData['category']}' not found");

        // Weight in kg
        $weight =$itemData['weight'] ?? ' ';

        // Basic product info
      
            $product->category = $categoryId;
            $product->productDescription1 = $itemData['productDescription1'] ?? null;
            $product->productDescription2 = $itemData['productDescription2'] ?? null;
            $product->price = (float)($itemData['mrpPerUnit']);
            $product->discountPrice = (float)($itemData['sellPrice']);
            $product->discountPercentage = (float)($itemData['sellDiscountPercentage'] ?? 0);
            $product->size = '';
            $product->weight = $weight ?? '';
            $product->current_stock = $purchaseItem->quantity;
            $product->total_stock = $purchaseItem->quantity;
            $product->image1 = $this->handleImageUpload($itemData['image1'] ?? null, $product->image1 ?? null);
            $product->image2 = $this->handleImageUpload($itemData['image2'] ?? null, $product->image2 ?? null);
            $product->image3 = $this->handleImageUpload($itemData['image3'] ?? null, $product->image3 ?? null);

            $product->shipping_fee = (float)($itemData['shippingFee'] ?? 0);
            $product->availability = (int)($itemData['availability'] ?? 1);
            $product->on_sell = (int)($itemData['on_sell'] ?? 1);
            $product->add_timer = (int)($itemData['addTimer'] ?? 0);
            $product->timer_end_at = !empty($itemData['timerDatetime']) ? $itemData['timerDatetime'] : null;
            $product->barcode = $itemData['barcode'] ?? null;

           
            $product->tax_rate = $itemData['tax_group_id'];


            $product->hsn_code = $itemData['hsnCode'] ?? null;
            $product->mrp = (float)($itemData['mrpPerUnit'] ?? 0);
            $product->brand = $itemData['brand'] ?? null;
            $product->rfid = $itemData['stock'] ?? null;

            if (!$product->exists) {
                $product->coupon_code = 'DISC-' . Str::upper(Str::random(6));
            }

            $product->save();

        // Determine if product has variants
        if (!empty($itemData['variants']) && is_array($itemData['variants'])) {
            $product->product_type = 'variant';
            $totalStock = 0;

            foreach ($itemData['variants'] as $variantData) {
                if (empty($variantData['size']) && empty($variantData['stock'])) continue;

                $size = $variantData['size'] ?? 'free';
                $stock = (int)($variantData['stock'] ?? $purchaseItem->quantity);
                $price = (float)($variantData['price'] ?? $itemData['sellPrice']);
                $discount_price = (float)($variantData['discount_price'] ?? $itemData['sellPrice']);
                $variantWeight = $variantData['weight']  ?? '';

                if ($stock > 0) {
                    $variant = ProductVariant::firstOrNew([
                        'product_id' => $product->id,
                        'size' => $size,
                    ]);
                    $variant->stock = $variant->exists ? ($variant->stock + $stock) : $stock;
                    $variant->price = $price;
                    $variant->discount_price = $discount_price;
                    $variant->weight = $variantWeight;
                    $variant->save();

                    $totalStock += $stock;
                }
            }

            $product->total_stock = $totalStock;
            $product->current_stock = $totalStock;
            $product->save();

        } else {
            // Simple product
            $product->product_type = 'simple';
            $stock = (int)($itemData['quantity'] ?? $purchaseItem->quantity);

            $product->total_stock = $stock;
            $product->current_stock = $stock;
            $product->save();

            // Ensure a default variant exists
            $variant = ProductVariant::firstOrNew([
                'product_id' => $product->id,
                'size' => 'default',
            ]);
            $variant->stock = $stock;
            $variant->price = (float)($itemData['sellPrice'] ?? 0);
            $variant->discount_price = (float)($itemData['sellPrice'] ?? 0);
            $variant->weight = $weight;
            $variant->save();
        }

        // Link purchase item to product
        $purchaseItem->update(['product_id' => $product->id]);

    } catch (\Exception $e) {
        Log::error('Error in createOrUpdateProduct: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        throw $e;
    }
}



    private function handleImageUpload($image, $oldImage = null)
    {
        if ($image instanceof \Illuminate\Http\UploadedFile) {
            try {
                if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                return $image->storeAs('products', $imageName, 'public');
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return $oldImage;
            }
        }
        return $oldImage;
    }



    public function edit($id)
    {
        $purchase = Purchase::with([
            'items.product',
            'items.product.category',    // category relation
            'items.product.taxGroup',    // tax relation
            'vendor'
        ])->findOrFail($id);

        $vendors = Vendor::all();
        $products = Product::with(['category', 'taxGroup'])->get();
        $variantProduct = ProductVariant::where('product_id', $id)->get();
        
        $tax_groups = TaxGroup::with('taxes')->get()->filter(function ($group) {
            return $group->taxes->isNotEmpty();
        });
        
        $categories = Category::all();
        $purchaseItems = $purchase->items;

        return view('admin.invoices.purchases.edit', compact(
            'purchase', 
            'vendors', 
            'products', 
            'tax_groups', 
            'categories',
            'purchaseItems',
            'variantProduct'
        ));
    }








    /**
     * Update the specified purchase, its items, and related product/inventory data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        // JSON string ko array mein convert karo
        $itemsData = json_decode($request->items, true);

        $request->merge([
            'items' => $itemsData
        ]);

        // Validation
        $request->validate([
            'invoiceNumber' => [ 
                'required',
                'string',
                'max:255',
                Rule::unique('purchases', 'invoice_number')->ignore($id),
            ],
            'invoiceDate' => 'required|date',
            'vendorName' => 'required|exists:vendors,id',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_group_id' => 'required|exists:tax_groups,id',
        ]);

        DB::beginTransaction();

        try {
            $purchase = Purchase::findOrFail($id);

            // Update purchase details (Header)
            $purchase->invoice_number = $request->invoiceNumber;
            $purchase->invoice_date   = $request->invoiceDate;
            $purchase->vendor_id      = $request->vendorName;
            $purchase->save();

            $itemsData = $request->items;
            $grandTotal = 0;
            
            // --- ITEM DELETION LOGIC ---
            $submittedItemIds = collect($itemsData)
                ->pluck('id')
                ->filter()
                ->map(fn($id) => (int)$id)
                ->toArray();

            PurchaseItem::where('purchase_id', $purchase->id)
                ->whereNotIn('id', $submittedItemIds)
                ->delete();
            // --- END ITEM DELETION LOGIC ---

        foreach ($itemsData as $index => $itemData) {
                $productData = $itemData['product_data'] ?? [];
                $stock = (int)($itemData['quantity'] ?? 0);

                // --- Purchase Item update/create
                $isExistingItem = !empty($itemData['id']);
                $purchaseItem = null; 

                if ($isExistingItem) {
                    $purchaseItem = PurchaseItem::where('purchase_id', $purchase->id)
                        ->where('id', $itemData['id'])
                        ->first();
                    if (!$purchaseItem) {
                        $purchaseItem = new PurchaseItem();
                        $purchaseItem->purchase_id = $purchase->id;
                    }
                } else {
                    $purchaseItem = new PurchaseItem();
                    $purchaseItem->purchase_id = $purchase->id;
                }
                
                // Set PurchaseItem attributes
                $purchaseItem->product_id           = $itemData['product_id'] ?? null;
                $purchaseItem->product_name         = $itemData['product_name'];
                $purchaseItem->item_code            = $itemData['item_code'] ?? null;
                $purchaseItem->quantity             = $itemData['quantity'];
                $purchaseItem->unit_price           = $itemData['unit_price'];
                $purchaseItem->discount_percentage  = $itemData['discount_percentage'] ?? 0;
                $purchaseItem->tax_group_id         = $itemData['tax_group_id'];
                
                $purchaseItem->net_price            = $itemData['netPrice'] 
                                                    ?? ($isExistingItem ? $purchaseItem->net_price : 0.00);

                $purchaseItem->tax_amount           = $itemData['lineTaxAmount'] 
                                                    ?? ($isExistingItem ? $purchaseItem->tax_amount : 0.00);

                $purchaseItem->total_incl_tax       = $itemData['total_incl_tax'] 
                                                    ?? ($isExistingItem ? $purchaseItem->total_incl_tax : 0.00);

                $purchaseItem->save();

                // --- Product update/create logic
                try {
                    if (!empty($itemData['product_id'])) {
                        $product = Product::find($itemData['product_id']) ?? new Product();
                    } else {
                        $product = new Product();
                    }

                    $categoryId = Category::where('name', $productData['category_name'])->value('id');
                    if (!$categoryId) {
                        throw new \Exception("Category '{$productData['category_name']}' not found for item index {$index}.");
                    }

                    $weight = $productData['weight'] ?? '';

                    // Setting Product attributes
                    $product->productName         = $productData['productName'];
                    $product->category            = $categoryId;
                    $product->productDescription1 = $productData['productDescription1'] ?? null;
                    $product->productDescription2 = $productData['productDescription2'] ?? null;
                    $product->price               = (float)($productData['mrp'] ?? 0);
                    $product->discountPrice       = (float)($productData['discountPrice'] ?? 0);
                    $product->discountPercentage  = (float)($productData['discountPercentage'] ?? $productData['sellDiscountPercentage'] ?? 0);
                    $product->size                = '';
                    $product->weight              = $weight ?? '';
                    $product->shipping_fee        = (float)($productData['shipping_fee'] ?? $productData['shippingFee'] ?? 0);
                    $product->availability        = (int)($productData['availability'] ?? 1);
                    $product->on_sell             = (int)($productData['on_sell'] ?? 1);
                    $product->add_timer           = (int)($productData['add_timer'] ?? $productData['addTimer'] ?? 0);
                    $product->timer_end_at        = !empty($productData['timer_end_at'])
                        ? $productData['timer_end_at']
                        : (!empty($productData['timerDatetime']) ? $productData['timerDatetime'] : null);
                    $product->barcode             = $productData['barcode'] ?? null;
                    $product->tax_rate            = $productData['tax_group_id'] ?? $itemData['tax_group_id']; 
                    $product->hsn_code            = $productData['hsn_code'] ?? null;
                    $product->mrp                 = (float)($productData['mrp'] ?? 0);
                    $product->brand               = $productData['brand'] ?? null;
                    $product->rfid                = $productData['stock'] ?? null;
                    
                    // Set stock before the first save
                    $product->total_stock = $product->total_stock ?? $stock;
                    $product->current_stock = $product->current_stock ?? $stock;

                    if (!$product->coupon_code) {
                        $product->coupon_code = 'DISC-' . Str::upper(Str::random(6));
                    }

        // --- Image uploads: Use the fixed helper function ---
                        $product->image1 = $this->handleImageUploadUpdate(
                            $request, $index, 'image1',
                            $productData['image1'] ?? null,    // JSON value: 'REMOVED', 'UPLOAD', or existing path
                            $product->image1 ?? null           // Existing path in DB
                        );
                        $product->image2 = $this->handleImageUploadUpdate(
                            $request, $index, 'image2',
                            $productData['image2'] ?? null,
                            $product->image2 ?? null
                        );
                        $product->image3 = $this->handleImageUploadUpdate(
                            $request, $index, 'image3',
                            $productData['image3'] ?? null,
                            $product->image3 ?? null
                        );
                    // --- End Image uploads ---
                    
                    $product->save();

                    // --- Variants OR simple product
                    $hasVariants = !empty($productData['variants']) && is_array($productData['variants']) && count($productData['variants']) > 0;
                    
                    // पुराने Variants को डिलीट करें
                    ProductVariant::where('product_id', $product->id)->delete();

                    $calculatedTotalStock = 0;

                    if ($hasVariants) {
                        $product->product_type = 'variant';
                        foreach ($productData['variants'] as $variantData) {
                            if (empty($variantData['size']) && empty($variantData['stock'])) continue;

                            $variant = new ProductVariant();
                            $variant->product_id = $product->id;
                            $variant->size = $variantData['size'] ?? 'default';
                            $variant->stock = (int)($variantData['stock'] ?? 0);
                            $variant->price = (float)($variantData['price'] ?? $productData['mrpPerUnit'] ?? 0);
                            $variant->discount_price = (float)($variantData['discount_price'] ?? $productData['sellPrice'] ?? 0);
                            $variant->weight = !empty($variantData['weight']) ? ((float)$variantData['weight']) : $weight;
                            $variant->save();

                            $calculatedTotalStock += $variant->stock;
                        }

                        $product->total_stock = $calculatedTotalStock;
                        $product->current_stock = $calculatedTotalStock;

                    } else {
                        $product->product_type = 'simple';
                        $stock = (int)($itemData['quantity'] ?? $purchaseItem->quantity);

                        $product->total_stock = $stock; 
                        $product->current_stock = $stock; 
                        
                        $variant = new ProductVariant();
                        $variant->product_id = $product->id;
                        $variant->size = 'default';
                        $variant->stock = $stock;
                        $variant->price = (float)($productData['mrpPerUnit'] ?? 0);
                        $variant->discount_price = (float)($productData['sellPrice'] ?? 0);
                        $variant->weight = $weight;
                        $variant->save();
                    }

                    // product_type और स्टॉक काउंट को स्टोर करने के लिए फिर से सेव करें।
                    $product->save();

                    // PurchaseItem को Product ID से लिंक करें
                    if (!$purchaseItem->product_id) {
                        $purchaseItem->product_id = $product->id;
                        $purchaseItem->save();
                    }

                } catch (\Exception $e) {
                    Log::error("Product update error for item index {$index}: " . $e->getMessage());
                    throw $e; 
                }
                // --- End Product update/create

                $grandTotal += floatval($purchaseItem->total_incl_tax);
            }
            
            $purchase->grand_total = $grandTotal;
            $purchase->save();

            DB::commit();
            return redirect()->route('purchase.index') 
            ->with('info', 'Purchase updated successfully!');


        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput() 
                ->with('error', 'Failed to update purchase: ' . $e->getMessage());
        }
    }


    private function handleImageUploadUpdate(Request $request, int $index, string $imageKey, $jsonValue, $existingImagePath)
    {
        // *** FIXED: Use the correct file input name structure ***
        $fileInputName = "item_files.{$index}.{$imageKey}";
        
        $uploadedFile = $request->file($fileInputName);

        // =========================================================================
        // 📌 DEBUG LOG: Check if file is found
        // =========================================================================
        if ($uploadedFile) {
            Log::debug("Image Check for {$fileInputName}: ✅ File Found. Size: " . $uploadedFile->getSize() . " bytes. Original Name: " . $uploadedFile->getClientOriginalName());
        } else {
            Log::debug("Image Check for {$fileInputName}: ❌ File NOT Found in Request.");
        }
        // =========================================================================

        // --- Scenario 1: Image Removal ---
        if ($jsonValue === 'REMOVED') {
            Log::debug("Image Action for {$fileInputName}: Marked for REMOVAL. Deleting old path: {$existingImagePath}");
            if (!empty($existingImagePath) && Storage::disk('public')->exists($existingImagePath)) {
                Storage::disk('public')->delete($existingImagePath);
            }
            return '';
        }

        // --- Scenario 2: New File Upload ---
        if ($uploadedFile instanceof \Illuminate\Http\UploadedFile) {
            try {
                $extension = $uploadedFile->getClientOriginalExtension();

                if (empty($extension)) {
                    Log::error("New image upload failed: Missing file extension for: {$fileInputName}");
                    return $existingImagePath ?? ''; 
                }
                
                $imageName = time() . '_' . Str::random(10) . '.' . $extension;
                
                // Store the file
                $newPath = $uploadedFile->storeAs('products', $imageName, 'public');
                
                if (!$newPath) {
                    Log::error("Failed to store new image: {$imageName} on public disk.");
                    throw new \Exception("Failed to store new product image: {$imageName}");
                }
                
                // Delete old file
                if (!empty($existingImagePath) && Storage::disk('public')->exists($existingImagePath)) {
                    Storage::disk('public')->delete($existingImagePath);
                    Log::debug("Image Action for {$fileInputName}: Upload Success. Old image deleted: {$existingImagePath}");
                } else {
                    Log::debug("Image Action for {$fileInputName}: Upload Success. No old image to delete.");
                }
                
                return $newPath;

            } catch (\Exception $e) {
                Log::error('Image upload failed during processing (Exception): ' . $e->getMessage() . ' for input: ' . $fileInputName);
                throw $e; 
            }
        }

        // --- Scenario 3: Image Upload Marker but no file found ---
        if ($jsonValue === 'UPLOAD' && !$uploadedFile) {
            Log::warning("Image Action for {$fileInputName}: UPLOAD marker set but no file found in request. Keeping existing image.");
            return $existingImagePath ?? '';
        }

        // --- Scenario 4: No changes - retain existing path ---
        Log::debug("Image Action for {$fileInputName}: Retained/No Change. Path: " . ($existingImagePath ?? 'None'));
        return $existingImagePath ?? '';
    }




    public function destroy(Purchase $purchase)
    {
        $purchase->items()->delete();
        $purchase->delete();
        return redirect()->route('purchase.index')->with('success', 'Purchase deleted successfully!');
    }
}