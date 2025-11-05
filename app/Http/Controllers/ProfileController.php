<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Cart;
use App\Models\GiftProduct;
use App\Models\Address;
use App\Models\WishlistItem;
use App\Models\Product;

class ProfileController extends Controller
{
public function update(Request $request)
{
    $request->validate([
        'dob' => 'nullable|date',
        'gender' => 'nullable|string',
        'city' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:20',
        'country' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/storage/products/profiles/' , 'public');
            // $imagePath = $image->store('products/profiles', 'public');

            $user->profile_image = $imagePath;
        }

        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->country = $request->country;
        $user->address = $request->address;
        $user->save();

        return response()->json(['message' => 'Profile updated successfully.']);
    } catch (\Exception $e) {
        \Log::error("Profile Update Error: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'message' => 'Error updating profile. Please check the logs for details.',
            'error' => $e->getMessage()
        ], 500);
    }
}

// public function show(){
//     $user = Auth::user();
//     $addresses = Address::where('user_id', Auth::id())->get();
//         return view('account', compact('addresses','user')); //
// }

public function show()
{
    $user = Auth::user();
    $addresses = Address::where('user_id', $user->id)->get();

    // --- Cart logic ---
    $cartItems = [];
    $subtotal = 0;
    $shippingCost = 18.00; // Example shipping

    if (Auth::check()) {
        $customer_id = Auth::id();
        $cartItems = Cart::with('product')
            ->where('customer_id', $customer_id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product ? ($item->product->discountPrice ?? $item->product->price) * $item->product_qty : 0;
        });
    } else {
        $cartItems = Session::get('cart', []);
        foreach ($cartItems as &$item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $item['product'] = $product;
                $subtotal += ($product->discountPrice ?? $product->price) * $item['product_qty'];
            }
        }
    }

    $total = $subtotal + $shippingCost;
    $giftProduct = GiftProduct::where('is_active', true)->first();

    // --- Wishlist logic ---
    $wishlist = WishlistItem::where('user_id', $user->id)->get();
    $productIds = $wishlist->pluck('product_id');
    $wishlistItems = Product::whereIn('id', $productIds)->get();

    // ✅ Return data properly
    return view('account', [
        'user'          => $user,
        'addresses'     => $addresses,
        'cartItems'     => $cartItems,
        'subtotal'      => $subtotal,
        'shippingCost'  => $shippingCost,
        'total'         => $total,
        'giftProduct'   => $giftProduct,
        'wishlistItems' => $wishlistItems, // ✅ Fixed key name
    ]);
}



 public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'nullable|string|max:50',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:15',
            'gender'     => 'nullable|in:Male,Female,Other',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

}
