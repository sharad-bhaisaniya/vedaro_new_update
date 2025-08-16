<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); // For sidebar
        $categoryList = Category::pluck('name')->toArray(); // For random product assignment
        $products = Product::get();
       
        if ($request->has('category')) {
            $products = Product::where('category', $request->category)->get();
            $currentCategory = Category::find($request->category);
            $currentCategoryName = $currentCategory ? $currentCategory->name : null;
        } else {
            $products = Product::all();
            $currentCategoryName = null;
        }

        return view('show_categories', compact('categories', 'products', 'currentCategoryName')); 
    }
      public function toggleShowOnHome($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->showOnHome = !$category->showOnHome;
            $category->save();
    
            return response()->json([
                'success' => true,
                'status' => $category->showOnHome
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


}
