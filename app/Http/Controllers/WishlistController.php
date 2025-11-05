<?php

namespace App\Http\Controllers;

use App\Models\WishlistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
   use App\Models\Product; // Make sure to import the Product model


class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */


public function index()
{
    if (Auth::check()) {
        $user = Auth::user();

        // 1. Get the session wishlist data
        $sessionWishlist = session()->get('wishlist', []);

        // 2. Check if the session wishlist has any items
        if (!empty($sessionWishlist)) {
            $productIds = array_map('intval', $sessionWishlist);

            // 3. Get the user's existing database wishlist items to avoid duplicates
            $existingWishlistItems = $user->wishlistItems()->pluck('product_id')->toArray();

            // 4. Loop through the session items and save them to the database
            foreach ($productIds as $productId) {
                if (!in_array($productId, $existingWishlistItems)) {
                    $wishlistItem = new WishlistItem([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ]);
                    $wishlistItem->save();
                }
            }

            // 5. Clear the session wishlist
            session()->forget('wishlist');
        }

        // 6. After the migration, retrieve the complete wishlist from the database
        $wishlistItems = $user->wishlistItems()->with('product')->get();

    } else {
        // This part remains the same for guest users
        $productIds = session()->get('wishlist', []);

        if (empty($productIds)) {
            $wishlistItems = collect();
        } else {
            $productIds = array_map('intval', $productIds);
            $productsFromSession = Product::whereIn('id', $productIds)->get();

            $wishlistItems = $productsFromSession->map(function ($product) {
                $wishlistItem = new \stdClass();
                $wishlistItem->product = $product;
                return $wishlistItem;
            });
        }
    }

    return view('favorite', compact('wishlistItems'));
}
    /**
     * Add a product to the user's wishlist.
     */
public function store(Request $request)
{
    // Check if the user is a guest
    if (!Auth::check()) {
        $wishlist = session()->get('wishlist', []);
        $product_id = $request->input('product_id');

        if (!in_array($product_id, $wishlist)) {
            $wishlist[] = $product_id;
            session()->put('wishlist', $wishlist);
            return back()->with('success', 'Product added to your wishlist!');
        }

        return response()->json(['message' => 'Product added to wishlist.']);
    }

    // User is logged in
    $user = Auth::user();
    $product_id = $request->input('product_id');

    // Check for duplicates
    if ($user->wishlistItems()->where('product_id', $product_id)->exists()) {
        return response()->json(['message' => 'Product already added in wishlist.']);
    }

    $wishlistItem = new WishlistItem([
        'user_id' => $user->id,
        'product_id' => $product_id,
    ]);
    $wishlistItem->save();

  
    return response()->json(['message' => 'Product added to wishlist.']);
}

    /**
     * Remove a product from the user's wishlist.
     */
    // public function destroy(WishlistItem $wishlistItem)
    // {
    //     // Ensure the authenticated user owns this wishlist item
    //     if ($wishlistItem->user_id !== Auth::id()) {
    //         return response()->json(['message' => 'Unauthorized action.'], 403);
    //     }

    //     $wishlistItem->delete();

    //     return response()->json(['message' => 'Product removed from wishlist successfully.']);
    // }
    public function destroy($productId)
{
    // If the user is a guest
    if (!Auth::check()) {
        $wishlist = session()->get('wishlist', []);
        $productId = intval($productId);

        // Find the key of the item to be removed
        $key = array_search($productId, $wishlist);

        if ($key !== false) {
            unset($wishlist[$key]);
            session()->put('wishlist', array_values($wishlist)); // Re-index the array
            return response()->json(['message' => 'Product removed from session wishlist.']);
        }

        return response()->json(['message' => 'Product not found in session wishlist.'], 404);
    }

    // If the user is logged in
    $wishlistItem = WishlistItem::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();

    if (!$wishlistItem) {
        return response()->json(['message' => 'Product not found in your wishlist.'], 404);
    }

    $wishlistItem->delete();

    return response()->json(['message' => 'Product removed from wishlist successfully.']);
}
}