<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ProductIdentifier;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all(); 

        $similarProducts = Product::where('id', '!=', $product->id)
            ->get();

        return view('product_details', compact('product', 'categories', 'similarProducts'));
    }

    public function updateWeight(Request $request, Product $product)
    {
        $validated = $request->validate([
            'weight' => 'required|string'
        ]);

        $product->update([
            'weight' => $request->weight
        ]);

        return response()->json(['success' => true]);
    }

    public function updateSize(Request $request, $id)
    {
        $request->validate([
            'size' => 'required|string|max:255'
        ]);

        $product = Product::findOrFail($id);
        $product->size = $request->size;
        $product->save();

        return response()->json(['success' => true]);
    }

/**
 * Find product by barcode - Search in ProductIdentifier using qr_code
 */
// public function findByBarcode($barcode)
// {
//     try {
//         Log::info('=== BARCODE SCAN STARTED ===');
//         Log::info('Searching for barcode: ' . $barcode);
        
//         // Search in product_identifiers table
//         Log::info('Step 1: Searching in ProductIdentifier table');
//         $identifier = ProductIdentifier::where('qr_code', $barcode)->first();
        
//         if ($identifier) {
//             Log::info('✅ ProductIdentifier FOUND', [
//                 'id' => $identifier->id,
//                 'product_id' => $identifier->product_id,
//                 'qr_code' => $identifier->qr_code
//             ]);
            
//             // Get the product
//             Log::info('Step 2: Fetching product with ID: ' . $identifier->product_id);
//             $product = Product::with(['variants', 'category'])->find($identifier->product_id);
            
//             if ($product) {
//                 Log::info('✅ PRODUCT FOUND', [
//                     'product_id' => $product->id,
//                     'product_name' => $product->productName,
//                     'product_type' => $product->product_type,
//                     'variants_count' => $product->variants->count()
//                 ]);
                
//                 $response = $product->getFormattedForBarcodeResponse();
//                 Log::info('✅ Sending response to frontend');
//                 return response()->json($response);
//             } else {
//                 Log::warning('❌ Product not found for ProductIdentifier product_id: ' . $identifier->product_id);
//                 return response()->json(['error' => 'Product not found for this barcode'], 404);
//             }
//         }
        
//         Log::warning('❌ Barcode not found in ProductIdentifier: ' . $barcode);
//         return response()->json(['error' => 'Barcode not found in database'], 404);
        
//     } catch (\Exception $e) {
//         Log::error('💥 ERROR in findByBarcode: ' . $e->getMessage());
//         Log::error('Stack trace: ' . $e->getTraceAsString());
//         return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
//     }
// }

public function findByBarcode($barcode)
{
    try {
        Log::info('=== BARCODE SCAN STARTED ===');
        Log::info('Searching for barcode: ' . $barcode);
        
        // Search in product_identifiers table
        $identifier = ProductIdentifier::where('qr_code', $barcode)->first();
        
        if (!$identifier) {
            Log::warning('❌ Barcode not found in ProductIdentifier: ' . $barcode);
            return response()->json(['error' => 'Barcode not found in database'], 404);
        }
        
        Log::info('✅ ProductIdentifier FOUND - Product ID: ' . $identifier->product_id);
        
        // Get the product with basic data first
        $product = Product::find($identifier->product_id);
        
        if (!$product) {
            Log::warning('❌ Product not found for ID: ' . $identifier->product_id);
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        Log::info('✅ PRODUCT FOUND: ' . $product->productName);
        
        // Load relationships if they exist
        if (method_exists($product, 'variants')) {
            $product->load('variants');
        }
        if (method_exists($product, 'category')) {
            $product->load('category');
        }
        
        // Build basic response
        $response = [
            'id' => $product->id,
            'productName' => $product->productName,
            'product_type' => $product->product_type ?? 'simple',
            'price' => $product->price ?? 0,
            'discountPrice' => $product->discountPrice ?? $product->price ?? 0,
            'hsn_code' => $product->hsn_code ?? '',
            'tax_rate' => $product->tax_rate ?? '',
            'tax_group_id' => $product->tax_group_id ?? null,
            'category' => $product->category ? (is_object($product->category) ? $product->category->name : Category::find($product->category)?->name) : 'No Category',

        ];
        
        // Add variants if they exist and product is variant type
        if (isset($product->variants) && $product->variants && $product->variants->count() > 0) {
            Log::info('🔧 Variants found: ' . $product->variants->count());
            $response['variants'] = $product->variants->map(function($variant) {
                return [
                    'id' => $variant->id,
                    'size' => $variant->size ?? '',
                    'price' => $variant->price ?? 0,
                    'discount_price' => $variant->discount_price ?? $variant->price ?? 0,
                ];
            })->toArray();
        } else {
            Log::info('🔧 No variants found or simple product');
            $response['variants'] = [];
        }
        
        Log::info('✅ Sending response to frontend');
        Log::info('Response: ', $response);
        
        return response()->json($response);
        
    } catch (\Exception $e) {
        Log::error('💥 ERROR in findByBarcode: ' . $e->getMessage());
        Log::error('Stack trace: ' . $e->getTraceAsString());
        return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
    }
}


public function getVariants(Product $product)
{
    $variants = $product->variants()->get(['id', 'size', 'price', 'discount_price', 'stock', 'weight']);
    
    return response()->json([
        'variants' => $variants
    ]);
}



 
}