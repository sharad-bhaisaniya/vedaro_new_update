<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;  // Ensure you import the Rating model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        // Fetch product details
        $product = Product::findOrFail($id);
        $categories = Category::all(); 
        // Pass both product and reviews data to the view
        return view('product_details', compact('product','categories'));  // Corrected compact
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

    
}
