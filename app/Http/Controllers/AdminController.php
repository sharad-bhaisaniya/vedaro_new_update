<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\ShiprocketOrder;
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
            "shipping_fee" => "required|numeric|min:0",
            "availability" => "required|boolean",
            "on_sell" => "required|boolean",
            "weight" => "nullable|string|max:255",
            "multiple_weights" => "nullable|array",
            "multiple_weights.*" => "nullable|string|max:255|distinct",
            "category" => "required|exists:categories,id",

            // optional stock fallback
            "stock" => "nullable|integer|min:0",

            // optional size stock
            "multiple_sizes" => "nullable|array",
            "size_stocks" => "nullable|array",
            "size_stocks.*" => "nullable|integer|min:0",
        ]);

        try {
            // Handle image uploads
            $imagePath1 = $request->file('productImage1')->store('products', 'public');
            $imagePath2 = $request->file('productImage2')?->store('products', 'public');
            $imagePath3 = $request->file('productImage3')?->store('products', 'public');

            // Timer calculation
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

            // Convert weight to kg
            $convertedWeight = $request->filled('weight') && is_numeric($request->weight)
                ? (string) ($request->weight / 1000)
                : null;

            // Convert multiple weights
            $convertedMultipleWeights = [];
            if ($request->has('multiple_weights')) {
                foreach ($request->multiple_weights as $w) {
                    $convertedMultipleWeights[] = is_numeric($w) ? (string) ($w / 1000) : $w;
                }
            }

            // Handle sizes and stocks
            $sizeStockMap = [];
            $totalStock = 0;
            $multipleSizes = [];

            if (is_array($request->multiple_sizes) && is_array($request->size_stocks)) {
                foreach ($request->multiple_sizes as $index => $size) {
                    $stock = (int) ($request->size_stocks[$index] ?? 0);
                    if ($size !== null && $size !== '') {
                        $sizeStockMap[$size] = $stock;
                        $totalStock += $stock;
                        $multipleSizes[] = $size;
                    }
                }
            }

            // Fallback to single stock if size/stock not used
            if ($totalStock === 0) {
                $totalStock = (int) $request->input('stock', 0);
            }

            // Create product
            $product = Product::create([
                'productName' => $request->productName,
                'coupon_code' => $request->coupon_code,
                'category' => $request->category,
                'size' => count($multipleSizes) > 0 ? $multipleSizes[0] : '',
                'multiple_sizes' => json_encode($multipleSizes),
                'size_stock' => json_encode($sizeStockMap),
                'total_stock' => $totalStock,
                'current_stock' => $totalStock,
                'weight' => $convertedWeight ?? '',
                'multiple_weights' => json_encode($convertedMultipleWeights),
                'productDescription1' => $request->productDescription1,
                'productDescription2' => $request->productDescription2,
                'price' => $request->price,
                'discountPercentage' => $request->discountPercentage,
                'discountPrice' => $request->discountPrice,
                'image1' => $imagePath1,
                'image2' => $imagePath2,
                'image3' => $imagePath3,
                'shipping_fee' => $request->shipping_fee,
                'availability' => $request->availability,
                'on_sell' => $request->on_sell,
                'add_timer' => $addTimer,
                'timer_end_at' => $endTime,
            ]);

            return redirect()->route('admin.add_product')->with([
        'swal' => [
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Product added successfully!',
            'timer' => 3000,
            'showConfirmButton' => false
        ]
    ]);

        } catch (\Exception $e) {
            // Delete uploaded images if something fails
            if (isset($imagePath1)) Storage::disk('public')->delete($imagePath1);
            if (isset($imagePath2)) Storage::disk('public')->delete($imagePath2);
            if (isset($imagePath3)) Storage::disk('public')->delete($imagePath3);

            return back()->withInput()->with('error', 'Error adding product: ' . $e->getMessage());
        }
    }

    $categories = Category::all();
return view('admin.add_product', compact('categories'))->with([
    'swal' => [
        'icon' => 'success',
        'title' => 'Success!',
        'text' => 'Product added successfully!',
        'timer' => 3000,
        'showConfirmButton' => false,
        'toast' => true,
        'position' => 'top-end'
    ]
]);
}




    // Edit Product
    public function edit_product($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit_product', compact('product', 'categories'))->with('success', 'Product Updated successfully');
    }




public function update_product(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        "productName" => "required|string|max:255",
        "coupon_code" => "required|string|max:255",
        "productDescription1" => "required|string",
        "productDescription2" => "nullable|string",
        "price" => "required|numeric|min:0",
        "discountPercentage" => "required|numeric|min:0|max:100",
        "discountPrice" => "nullable|numeric|min:0",
        "productImage1" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        "productImage2" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        "productImage3" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        "shipping_fee" => "required|numeric|min:0",
        "availability" => "required|boolean",
        "on_sell" => "required|boolean",
        "weight" => "nullable|string|max:255",
        "multiple_weights" => "nullable|array",
        "multiple_weights.*" => "nullable|string|max:255|distinct",
        "multiple_sizes" => "nullable|array",
        "size_stocks" => "nullable|array",
        "size_stocks.*" => "nullable|integer|min:0",
        "category" => "required|exists:categories,id",
        "stock" => "nullable|integer|min:0",
    ]);

    try {
        // Update images if present
        $image1 = $product->image1;
        $image2 = $product->image2;
        $image3 = $product->image3;

        if ($request->hasFile('productImage1')) {
            if ($image1) Storage::disk('public')->delete($image1);
            $image1 = $request->file('productImage1')->store('products', 'public');
        }

        if ($request->hasFile('productImage2')) {
            if ($image2) Storage::disk('public')->delete($image2);
            $image2 = $request->file('productImage2')->store('products', 'public');
        }

        if ($request->hasFile('productImage3')) {
            if ($image3) Storage::disk('public')->delete($image3);
            $image3 = $request->file('productImage3')->store('products', 'public');
        }

       
      // Timer update
            $addTimer = $request->has('addTimer');
            $endTime = $product->timer_end_at; // default: purana value
            
            if ($addTimer) {
                if ($request->filled('timerDatetime')) {
                    // Agar user ne direct datetime select kiya
                    $endTime = \Carbon\Carbon::parse($request->timerDatetime);
                } else {
                    // Agar days/hours/minutes se calculate kar rahe ho
                    $totalSeconds = ($request->timerDays * 86400) +
                                    ($request->timerHours * 3600) +
                                    ($request->timerMinutes * 60) +
                                    $request->timerSeconds;
            
                    if ($totalSeconds > 0) {
                        $endTime = now()->addSeconds($totalSeconds);
                    }
                }
            } elseif (!$addTimer) {
                // Agar timer remove karna ho to hi null karo
                $endTime = null;
            }


        // Convert weight to kg
        $convertedWeight = $request->filled('weight') && is_numeric($request->weight)
            ? (string) ($request->weight / 1000)
            : null;

        // Convert multiple weights to kg
        $convertedMultipleWeights = [];
        if ($request->has('multiple_weights')) {
            foreach ($request->multiple_weights as $w) {
                $convertedMultipleWeights[] = is_numeric($w) ? (string) ($w / 1000) : $w;
            }
        }

        // Handle sizes and stocks
        $multipleSizes = [];
        $sizeStockMap = [];
        $totalStock = 0;

        if (is_array($request->multiple_sizes) && is_array($request->size_stocks)) {
            foreach ($request->multiple_sizes as $index => $size) {
                $stock = (int) ($request->size_stocks[$index] ?? 0);
                if (!empty($size)) {
                    $multipleSizes[] = $size;
                    $sizeStockMap[$size] = $stock;
                    $totalStock += $stock;
                }
            }
        }

        if ($totalStock === 0) {
            $totalStock = (int) $request->input('stock', 0);
        }

        // Update the product
        $product->update([
            'productName' => $request->productName,
            'coupon_code' => $request->coupon_code,
            'category' => $request->category,
            'size' => count($multipleSizes) > 0 ? $multipleSizes[0] : '',
            'multiple_sizes' => json_encode($multipleSizes),
            'size_stock' => json_encode($sizeStockMap),
            'total_stock' => $totalStock,
            'current_stock' => $totalStock,
            'weight' => $convertedWeight ?? '',
            'multiple_weights' => json_encode($convertedMultipleWeights),
            'productDescription1' => $request->productDescription1,
            'productDescription2' => $request->productDescription2,
            'price' => $request->price,
            'discountPercentage' => $request->discountPercentage,
            'discountPrice' => $request->discountPrice,
            'image1' => $image1,
            'image2' => $image2,
            'image3' => $image3,
            'shipping_fee' => $request->shipping_fee,
            'availability' => $request->availability,
            'on_sell' => $request->on_sell,
            'add_timer' => $addTimer,
            'timer_end_at' => $endTime,
        ]);

    
        return redirect()->route('admin.manage_product')->with([
            'swal' => [
                'icon' => 'success',
                'title' => 'Success!',
                'text' => 'Product updated successfully!',
                'timer' => 3000,
                'showConfirmButton' => false
            ]
        ]);
    } catch (\Exception $e) {
        return back()->withInput()->with([
            'swal' => [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Error updating product: ' . $e->getMessage(),
                'showConfirmButton' => true
            ]
        ]);
    }
}




    
    // Delete Product
    public function delete_product($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    
        // Only use 'with' to flash the message
        return redirect()->route('admin.manage_product')->with('success', 'Product deleted successfully!');
    }
        


// -----------------product count----------------
    public function dashboard()
    {
        // Get the count of products and users
        $productCount = Product::count();
        $userCount = User::count();
    
        // Get order counts based on status
        $totalOrders = ShiprocketOrder::count();
        $paidOrders = ShiprocketOrder::where('status', 'new')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $cancelledOrders = ShiprocketOrder::where('status', 'CANCELED')->count();
    
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
    $products = Product::orderBy('created_at', 'desc')->get();
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
        // --- GET Method: Show the form ---
        if ($request->isMethod("get")) {
            // If you need to pass existing categories or data to the form view,
            // you can fetch them here.
            // $categories = Category::all();
            return view("admin.categories"); // Assuming this view contains your form
        }

        // --- POST Method: Handle form submission ---
        if ($request->isMethod("post")) {
            $validated = $request->validate([
                "name" => "required|string|max:255",
                "description" => "nullable|string",
                // Keep other image validations if needed for different fields
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
                // Modified icon validation for SVG files
                "icon" => "nullable|file|mimes:svg|max:2048", // Use 'file' and 'svg' mime type
                "banner_image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
                "showOnHome" => "nullable|boolean",
            ]);

            try {
                $imagePath = null;
                if ($request->hasFile("image")) {
                    $imagePath = $request->file("image")->store("categories/images", "public"); // Store in a subfolder
                }

                $iconPath = null;
                if ($request->hasFile("icon")) {
                    // Store SVG in a dedicated folder
                    $iconPath = $request->file("icon")->store("categories/icons", "public");
                }

                $bannerImagePath = null;
                if ($request->hasFile("banner_image")) {
                    $bannerImagePath = $request->file("banner_image")->store("categories/banners", "public"); // Store in a subfolder
                }

                // --- Store New Category ---
                // Assuming you are creating a new category here.
                // If this method is also handling updates, you'll need to differentiate.
                Category::create([
                    "name" => $validated["name"],
                    "description" => $validated["description"],
                    "image" => $imagePath,
                    "icon" => $iconPath, // This will store the path to the SVG file
                    "banner_image" => $bannerImagePath,
                    "showOnHome" => $request->has('showOnHome'),
                ]);

                return redirect()->route("admin.categories")->with("success", "Category added successfully!");

            } catch (\Exception $e) {
                Log::error("Category Creation Failed: " . $e->getMessage());
                return redirect()->route("admin.categories")->withErrors("Failed to add category. Please try again.");
            }
        }

        // If it's neither GET nor POST, or if there's an issue, you might want to return an error or redirect.
        return redirect()->route("admin.categories")->withErrors("Invalid request method.");
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
    // Find the category to update
    $category = Category::findOrFail($id);

    // Validate the request, adjusting validation for the icon field
    $validated = $request->validate([
        "name" => "required|string|max:255|unique:categories,name," . $category->id,
        "description" => "nullable|string",
        "image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        "icon_file" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048", // Changed to icon_file
        "icon_svg" => "nullable|string", // New validation for SVG string
        "banner_image" => "nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048",
        "showOnHome" => "nullable|boolean",
        "remove_image" => "nullable|boolean",
        "remove_icon" => "nullable|boolean",
        "remove_banner_image" => "nullable|boolean",
    ]);

    // Initialize paths
    $imagePath = $category->image;
    $iconPath = $category->icon;
    $bannerImagePath = $category->banner_image;

    // Handle Category Image
    if ($request->hasFile("image")) {
        // Delete old image
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        // Store new image
        $imagePath = $request->file("image")->store("categories", "public");
    } elseif ($request->has('remove_image')) {
        // Remove existing image
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        $imagePath = null;
    }

    // Handle Category Icon (Modified for file or SVG string)
    if ($request->hasFile("icon_file")) {
        // If a new icon file is uploaded, delete any existing icon (file or SVG)
        if ($iconPath && Storage::disk('public')->exists($iconPath)) {
            Storage::disk('public')->delete($iconPath);
        }
        $iconPath = $request->file("icon_file")->store("categories", "public");
    } elseif ($request->filled('icon_svg')) {
        // If an SVG string is provided, use it and clear any existing icon file
        if ($iconPath && Storage::disk('public')->exists($iconPath)) {
            Storage::disk('public')->delete($iconPath);
        }
        $iconPath = $request->input('icon_svg');
    } elseif ($request->has('remove_icon')) {
        // If the remove icon checkbox is checked, clear the icon field
        if ($iconPath && Storage::disk('public')->exists($iconPath)) {
            Storage::disk('public')->delete($iconPath);
        }
        $iconPath = null;
    }

    // Handle Category Banner Image
    if ($request->hasFile("banner_image")) {
        // Delete old banner image
        if ($bannerImagePath && Storage::disk('public')->exists($bannerImagePath)) {
            Storage::disk('public')->delete($bannerImagePath);
        }
        // Store new banner image
        $bannerImagePath = $request->file("banner_image")->store("categories", "public");
    } elseif ($request->has('remove_banner_image')) {
        // Remove existing banner image
        if ($bannerImagePath && Storage::disk('public')->exists($bannerImagePath)) {
            Storage::disk('public')->delete($bannerImagePath);
        }
        $bannerImagePath = null;
    }

    // Update the category with the new values
    $category->update([
        "name" => $validated["name"],
        "description" => $validated["description"],
        "image" => $imagePath,
        "icon" => $iconPath,
        "banner_image" => $bannerImagePath,
        "showOnHome" => $request->has('showOnHome'),
    ]);

    return redirect()->route("admin.manage_categories")->with("success", "Category updated successfully!");
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
                // if ($activeCount >= 4) {
                //     return redirect()->back()->with('error', 'Only 4 categories can be active at the same time.');
                // }
        
                $category->active = true;
            }
        
            $category->save();
        
            return redirect()->back()->with('success', 'Category status updated successfully.');
        }
        
        
        
        // --------------add gift products-----------------------------------------------


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
                        'productImage1' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                        'productImage2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                        'productImage3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                        'is_active' => 'sometimes|boolean',
                        'valid_from' => 'nullable|date',
                        'valid_to' => 'nullable|date|after_or_equal:valid_from',
                        'stock_quantity' => 'required|integer|min:0',
                        'minimum_cart_amount' => 'required|numeric|min:0',
                    ]);
            
                    $image1Path = $request->file('productImage1')->store('products', 'public');
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
                        'is_active' => $request->has('is_active'),
                        'valid_from' => $request->valid_from,
                        'valid_to' => $request->valid_to,
                        'stock_quantity' => $request->stock_quantity,
                        'minimum_cart_amount' => $request->minimum_cart_amount,
                    ]);
            
                    return redirect()->back()->with('success', 'Gift product added successfully!');
                }
            
                return view('admin.gift-product');
            }

// --------------manage gift products-----------------------------------------------
                public function manage_gift_products()
                {
                    $products = GiftProduct::all();
                    return view('admin.manage-gift-product', compact('products'));
                }

                public function toggleStatus(Request $request, $id)
            {
                // First deactivate all gifts
                GiftProduct::query()->update(['is_active' => false]);
            
                // Then activate the selected one if requested
                $gift = GiftProduct::findOrFail($id);
                $gift->update(['is_active' => $request->is_active]);
            
                return redirect()->back()->with('success', 'Gift status updated successfully');
            }

}
