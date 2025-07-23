<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\GiftProduct;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{


public function add_products(Request $request)
{
    if ($request->isMethod("post")) {
        $validated = $request->validate([
            "productName" => "required|string|max:255",
            "coupon_code" => "required|string|max:255",
            "productDescription1" => "required|string",
            "productDescription2" => "nullable|string",
            "price" => "required|numeric|min:0",
            "discountPercentage" => "required|numeric|min:0|max:100",
            "discountPrice" => "nullable|numeric|min:0",
            "productImage1" => "required|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "productImage2" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "productImage3" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
            "stock" => "required|integer|min:0",
            "shipping_fee" => "required|numeric|min:0",
            "availability" => "required|boolean",
            "on_sell" => "required|boolean",
            "weight" => "required|string|max:255",
            "size" => "required|string|max:255",
            "category" => "required|exists:categories,id",

        ]);

        try {
            // Handle image uploads
            $imagePath1 = $request->file('productImage1')->store('products', 'public');
            $imagePath2 = $request->file('productImage2') ? $request->file('productImage2')->store('products', 'public') : null;
            $imagePath3 = $request->file('productImage3') ? $request->file('productImage3')->store('products', 'public') : null;

            // Calculate timer end time if timer is enabled
            $endTime = null;
            $addTimer = $request->has('addTimer');
            
            if ($addTimer) {
                $totalSeconds = ($request->timerDays * 86400) + 
                               ($request->timerHours * 3600) + 
                               ($request->timerMinutes * 60) + 
                               $request->timerSeconds;
                
                if ($totalSeconds > 0) {
                    $endTime = now()->addSeconds($totalSeconds);
                }
            }

            // Create the product
           $product = Product::create([
                'productName' => $request->productName,
                'coupon_code' => $request->coupon_code,
                'category' => $request->category,
                'size' => $request->size,
                'weight' => $request->weight,
                'productDescription1' => $request->productDescription1,
                'productDescription2' => $request->productDescription2,
                'price' => $request->price,
                'discountPercentage' => $request->discountPercentage,
                'discountPrice' => $request->discountPrice,
                'image1' => $imagePath1,
                'image2' => $imagePath2,
                'image3' => $imagePath3,
                'stock' => $request->stock,
                'shipping_fee' => $request->shipping_fee,
                'availability' => $request->availability,
                'on_sell' => $request->on_sell,
                'add_timer' => $addTimer,
                'timer_end_at' => $endTime,
            ]);


            return redirect()->route('admin.add_product')->with('success', 'Product added successfully!');
            
        } catch (\Exception $e) {
            // Delete uploaded files if there was an error
            if (isset($imagePath1)) Storage::disk('public')->delete($imagePath1);
            if (isset($imagePath2)) Storage::disk('public')->delete($imagePath2);
            if (isset($imagePath3)) Storage::disk('public')->delete($imagePath3);
            
            return back()->withInput()->with('error', 'Error adding product: ' . $e->getMessage());
        }
    }

    $categories = Category::all();
    return view('admin.add_product', compact('categories'));
}


    // Edit Product
    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit_product', compact('product', 'categories'));
    }

    // Update Product
    public function update_product(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the form inputs
        $request->validate([
            "productName" => "required|string|max:255",
            "price" => "required|numeric",
            "discountPercentage" => "required|numeric",
            "size" => "required|string|max:255",
            "weight" => "required|numeric",
            "productDescription1" => "required|string",
            "productDescription2" => "required|string",
            "category" => "required|exists:categories,id",
            "availability" => "required|boolean",
            "on_sell" => "required|boolean",
            "stock" => "required|numeric",
            "shipping_fee" => "required|numeric",
            "coupon_code" => "nullable|string|max:255",
            "productImage1" => "nullable|image",
            "productImage2" => "nullable|image",
            "productImage3" => "nullable|image",
        ]);

        // Update product fields
        $product->update([
            "productName" => $request->productName,
            "price" => $request->price,
            "discountPercentage" => $request->discountPercentage,
            "size" => $request->size,
            "weight" => $request->weight,
            "productDescription1" => $request->productDescription1,
            "productDescription2" => $request->productDescription2,
            "category_id" => $request->category,
            "availability" => $request->availability,
            "on_sell" => $request->on_sell,
            "stock" => $request->stock,
            "shipping_fee" => $request->shipping_fee,
            "coupon_code" => $request->coupon_code,
            "add_timer" => $request->has('addTimer'),
            "timer_days" => $request->timerDays,
            "timer_hours" => $request->timerHours,
            "timer_minutes" => $request->timerMinutes,
            "timer_seconds" => $request->timerSeconds,

        ]);

        // Handle file uploads
       if ($request->hasFile("productImage1")) {
    $path = $request->file("productImage1")->store("product_images", "public"); // ✅ fix
    $product->image1 = $path;
    }
    
    if ($request->hasFile("productImage2")) {
        $path = $request->file("productImage2")->store("product_images", "public"); // ✅ fix
        $product->image2 = $path;
    }

    if ($request->hasFile("productImage3")) {
        $path = $request->file("productImage3")->store("product_images", "public"); // ✅ fix
        $product->image3 = $path;
    }


        $product->save();

        return redirect()
            ->route("admin.manage_product")
            ->with("success", "Product updated successfully!");
    }
    
    // Delete Product
    public function delete_product($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    
        session()->flash("success", "Product deleted successfully!");
        return redirect()->route("admin.manage_product");
    }


// -----------------product count----------------
    public function dashboard()
    {
        // Get the count of products and users
        $productCount = Product::count();
        $userCount = User::count();
    
        // Get order counts based on status
        $totalOrders = Order::count();
        $paidOrders = Order::where('status', 'paid')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $cancelledOrders = Order::where('status', 'cancel')->count();
    
        // Pass the counts to the view
        return view("admin.dashboard", compact(
            'productCount',
            'userCount',
            'totalOrders',
            'paidOrders',
            'pendingOrders',
            'cancelledOrders'
        ));
    }

// --------------------------------------------------------------------------------
    public function show_products()
    {
        $products = Product::all();
        return view("admin.manage_product", compact("products"));
    }
    
// --------------------------------------------------------------------------------
    public function timer_management()
    {
        return view("admin.timer_management");
    }
    
// ------------------------------------------------------
    public function handleCategoryForm(Request $request)
    {
        if ($request->isMethod("get")) {
            return view("admin.categories");
        }

        if ($request->isMethod("post")) {
            $validated = $request->validate([
                "name" => "required|string|max:255",
                "description" => "nullable|string",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048", // Image validation
            ]);

            try {
                $imagePath = null;
                if ($request->hasFile("image")) {
                    $imagePath = $request
                        ->file("image")
                        ->store("products", "public"); // Save in 'storage/app/public/categories'
                }

                Category::create([
                    "name" => $validated["name"],
                    "description" => $validated["description"],
                    "image" => $imagePath,
                ]);

                return redirect()
                    ->route("admin.categories")
                    ->with("success", "Category added successfully!");
            } catch (\Exception $e) {
                Log::error("Category Creation Failed: " . $e->getMessage());
                return redirect()
                    ->route("admin.categories")
                    ->withErrors("Failed to add category. Please try again.");
            }
        }
    }
// --------------------------------------------------------------------------------

    public function categoriesName()
    {
        $categories = Category::select("id", "name")->get();
        \Log::info("Fetched Categories: ", $categories->toArray());
        return view("admin.add_product", compact("categories"));
    }
// --------------------------------------------------------------------------------

    public function manageCategories()
    {
        $categories = Category::all(); // Fetch all categories
        return view("admin.manage_categories", compact("categories"));
    }
    
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view("admin.edit_category", compact("category"));
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile("image")) {
            if ($category->image) {
                \Storage::delete("public/" . $category->image);
            }
            $imagePath = $request->file("image")->store("categories", "public");
            $category->image = $imagePath;
        }

        $category->update([
            "name" => $validated["name"],
            "description" => $validated["description"],
            "image" => $category->image,
        ]);

        return redirect()
            ->route("admin.manage_categories")
            ->with("success", "Category updated successfully!");
    }
    
    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            \Storage::delete("public/" . $category->image);
        }

        $category->delete();

        return redirect()
            ->route("admin.manage_categories")
            ->with("success", "Category deleted successfully!");
    }
    
    
    // activation Category------------------------------------------
    
                
        public function toggleActive($id)
        {
            $category = Category::findOrFail($id);
        
            $activeCount = Category::where('active', true)->count();
        
            if ($category->active) {
                // Deactivating is always allowed
                $category->active = false;
            } else {
                // Only allow activating if total active categories < 4
                if ($activeCount >= 4) {
                    return redirect()->back()->with('error', 'Only 4 categories can be active at the same time.');
                }
        
                $category->active = true;
            }
        
            $category->save();
        
            return redirect()->back()->with('success', 'Category status updated successfully.');
        }

// --------------------------gift product----------
    public function add_gift_product(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'productName' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'size' => 'required|string|max:255',
                'weight' => 'required|string|max:255',
                'productDescription1' => 'required|string',
                'productDescription2' => 'nullable|string',
                'productImage1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'productImage2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'productImage3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);
    
            $image1Path = $request->hasFile('productImage1') ? $request->file('productImage1')->store('products', 'public') : null;
            $image2Path = $request->hasFile('productImage2') ? $request->file('productImage2')->store('products', 'public') : null;
            $image3Path = $request->hasFile('productImage3') ? $request->file('productImage3')->store('products', 'public') : null;
    
            GiftProduct::create([
                'product_name' => $request->productName,
                'price' => $request->price,
                'size' => $request->size,
                'weight' => $request->weight,
                'product_description1' => $request->productDescription1,
                'product_description2' => $request->productDescription2,
                'product_image1' => $image1Path,
                'product_image2' => $image2Path,
                'product_image3' => $image3Path,
            ]);
    
            return redirect()->back()->with('success', 'Gift product added successfully!');
        }
    
        return view('admin.gift-product'); // Update this to your form's view name
    }
    
// --------------manage gift products-----------------------------------------------
    public function manage_gift_products()
    {
        $products = GiftProduct::all();
        return view('admin.manage-gift-product', compact('products'));
    }

}
