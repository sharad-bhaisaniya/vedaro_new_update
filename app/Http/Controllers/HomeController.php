<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon; // Make sure to import Carbon if not already
use App\Models\LimitedEditionBanner;


class HomeController extends Controller
{

public function ShowOnHome()
{
    $products = Product::all();
    $featuredProducts = Product::where('availability', 1)->limit(1)->get();
    $categories = Category::all();
    $banners = Banner::all();
    $limitedEditionBanners = LimitedEditionBanner::latest()->get();
    // Get limited edition banners with their associated products
        $limitedEditionBanners->each(function($banner) {
        $productIds = explode(',', $banner->product_ids ?? '');
        $banner->products = Product::whereIn('id', $productIds)
            ->where('add_timer', true)
            ->where('timer_end_at', '>', Carbon::now())
            ->get();
    });
    return view('home', compact(
        'products',
        'categories',
        'banners',
        'featuredProducts',
        'limitedEditionBanners'
    ));
}
    


  public function showLimitedEdition()
    {
        // Fetch products that have active timers and the timer has not ended yet
                $limitedEditionProducts = Product::where('add_timer', 1)->get();

        // $limitedEditionProducts = Product::where('add_timer', true)
        //                                 ->where('timer_end_at', '>', Carbon::now())
        //                                 ->get();

        return view('limited_additions', compact('limitedEditionProducts'));
    }

    
   public function ShowOnShop()
    {
        $products = Product::all();  // Fetch all products
        $categories = Category::all();  // Fetch all categories
        return view('shop', compact('products', 'categories'));  // Pass products and categories to the view
    }
    
    
  public function index(Request $request , $id)
{
    $categories = Category::all();
    $currentCategoryName = null;

    // Start the query builder
    $products = Product::all();

    if ($id) {
        $products = $products->where('category', $id); // filter by category id
        $currentCategory = Category::find($id);
        $currentCategoryName = $currentCategory ? $currentCategory->name : null;
    }

    // $products = $products->get(); // finalize query

    return view('shop', compact('products', 'categories', 'currentCategoryName'));
}

    
    public function fetchProducts()
    {
        $products = Product::all();  // Fetch all products
        return response()->json($products);  // Return products as JSON response
    }

    // Fetch all categories
    public function fetchCategories()
    {
        $categories = Category::all();  // Fetch all categories
        return response()->json($categories);  // Return categories as JSON response
    }
    
        // Fetch products based on category
    public function fetchProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();  // Fetch products by category
        return response()->json($products);  // Return products as JSON response
    }
    
    public function showProfile()
    {
        
        // Fetch the logged-in user's data
        $user = Auth::user();
    
        // Pass the user data to the view
        return view('user_profile', compact('user'));
    }
        
}
