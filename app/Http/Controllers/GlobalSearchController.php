<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class GlobalSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

           // Get category IDs matching the search query
    $categories = Category::where('name', 'LIKE', "%$query%")->pluck('id');

    // Search products by product name OR by matched category id
    $products = Product::where('productName', 'LIKE', "%$query%")
        ->orWhereIn('category', $categories)
        ->get();

        return view('global_search', compact('products', 'categories', 'query'));
    }
}
