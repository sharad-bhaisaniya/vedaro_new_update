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
      
    
}
