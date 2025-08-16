<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;

use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(){
          return view('admin.coupons.generate_coupon', [
        'categories' => Category::all(),
        'products' => Product::all(),
    ]);
    }
public function store(Request $request)
{
    $validated = $request->validate([
        'code' => 'required|string|max:255',
        'discount_percentage' => 'required|numeric|min:0|max:100',
        'category_id' => 'nullable|exists:categories,id',
        'product_ids' => 'nullable|array',
        'product_ids.*' => 'exists:products,id',
        'valid_from' => 'nullable|date',
        'valid_to' => 'nullable|date|after_or_equal:valid_from',
    ]);

    $coupon = new Coupon();
    $coupon->code = $validated['code'];
    $coupon->discount_percentage = $validated['discount_percentage'];
    $coupon->category_id = $validated['category_id'] ?? null;
    $coupon->valid_from = $validated['valid_from'] ?? null;
    $coupon->valid_to = $validated['valid_to'] ?? null;
    $coupon->is_universal = $request->has('is_universal');

    // ✅ Store product_ids as array or null
    $coupon->product_ids = $validated['product_ids'] ?? null;

    $coupon->save();

    return redirect()->route('coupon.index')->with('success', 'Coupon created successfully.');
}

public function show()
{
   $universalCoupons = Coupon::where('is_universal', true)->latest()->get();
    $categoryCoupons = Coupon::where('is_universal', false)->whereNotNull('category_id')->latest()->get();
    $productCoupons = Coupon::where('is_universal', false)->whereNotNull('product_ids')->latest()->get();

    return view('admin.coupons.All_coupon', compact('universalCoupons', 'categoryCoupons', 'productCoupons'));
}



// public function update(Request $request, Coupon $coupon)
// {
//     $validated = $request->validate(Coupon::rules($coupon->id));

//     $coupon->update($validated);

//     return response()->json($coupon);
// }

public function edit(Coupon $coupon)
{
    return view('admin.coupons.edit_coupon', [
        'coupon' => $coupon,
        'categories' => Category::all(),
        'products' => Product::all(),
    ]);
}
public function update(Request $request, Coupon $coupon)
{
    $validated = $request->validate([
        'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
        'discount_percentage' => 'required|numeric|min:0|max:100',
        'category_id' => 'nullable|exists:categories,id',
        'product_ids' => 'nullable|array',
        'product_ids.*' => 'exists:products,id',
        'valid_from' => 'nullable|date_format:Y-m-d\TH:i',
        'valid_to' => 'nullable|date_format:Y-m-d\TH:i|after_or_equal:valid_from',
    ]);

    // Convert product_ids to JSON if present
    $productIds = isset($validated['product_ids'])
        ? json_encode($validated['product_ids'])
        : null;

    $coupon->update([
        'code' => $validated['code'],
        'discount_percentage' => $validated['discount_percentage'],
        'category_id' => $validated['category_id'] ?? null,
        'product_ids' => $productIds,
        'valid_from' => $validated['valid_from'] ?? null,
        'valid_to' => $validated['valid_to'] ?? null,
        'is_universal' => $request->has('is_universal'),
    ]);

    return redirect()->route('coupon.show')->with('success', 'Coupon updated successfully.');
}

public function delete($id){
$coupon = Coupon::find($id);
$coupon->delete();

 return redirect()->route('coupon.show')->with('success', 'Coupon Deleted successfully.');
}

}
