<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\GiftProduct;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\UserAddress;
use App\Models\Coupon;
use App\Models\ProductVariant;


class CartController extends Controller
{

        public function cart_view()
        {
            // Remove applied coupon data
            Session::forget(['cart_discount', 'cart_discount_percentage', 'applied_coupon', 'total_amount']);

            $cartItems = [];
            $subtotal = 0;
            $shippingCost = 18.00; // Example shipping cost

            if (Auth::check()) {
                // Logged-in users: get cart from DB
                $customer_id = Auth::id();
                $cartItems = Cart::with('product')
                    ->where('customer_id', $customer_id)
                    ->get();

                $subtotal = $cartItems->sum(function ($item) {
                    return $item->product ? $item->product->price * $item->product_qty : 0;
                });
            } else {
                // Guest users: get cart from session
                $sessionCart = Session::get('cart', []);
                $cartItems = [];

                foreach ($sessionCart as $key => $item) {
                    $product = Product::find($item['product_id']); // Optional: attach product details
                    $cartItems[$key] = $item;

                    if ($product) {
                        $cartItems[$key]['product'] = $product;
                    }

                    // Use session price & product_qty
                    $price = $item['price'] ;
                    $quantity = $item['product_qty'] ?? 1;
                    $cartItems[$key]['product_qty'] = $quantity;

                    $subtotal += $price * $quantity;

                    // Optional: also calculate total for each item
                    $cartItems[$key]['total'] = $price * $quantity;
                }
            }

            $total = $subtotal + $shippingCost;
            $giftProduct = GiftProduct::where('is_active', true)->first();

            return view('cart', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'shippingCost' => $shippingCost,
                'total' => $total,
                'giftProduct' => $giftProduct
            ]);
        }



// -----------------------------------------------------------------------------


        
                public function addToCart(Request $request)
        {
            try {
                $customerId = auth()->id();
        
                $productId = $request->input('product_id');
                $quantity = $request->input('product_qty', 1);
                $variantId = $request->input('variant_id', 0);
                $size = $request->input('size', 'Free Size');
        
                $product = Product::find($productId);
                if (!$product) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Product not found.',
                    ], 404);
                }
        
                // ✅ अगर प्रोडक्ट variant टाइप का है
                if ($product->product_type == 'variant') {
                    // अगर variantId नहीं भेजा गया → पहला variant लो
                    if ($variantId == 0 || empty($variantId)) {
                        $firstVariant = ProductVariant::where('product_id', $productId)->orderBy('id', 'asc')->first();
        
                        if (!$firstVariant) {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'No variants found for this product.',
                            ], 404);
                        }
        
                        $variantId = $firstVariant->id;
                        $size = $firstVariant->size;
                    }
        
                    $variant = ProductVariant::find($variantId);
                    if (!$variant) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Selected variant not found.',
                        ], 404);
                    }
        
                    $price = $variant->discount_price > 0 ? $variant->discount_price : $variant->price;
                    $weight = $variant->weight;
        
                    if ($variant->stock < $quantity) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Insufficient stock for selected variant.',
                        ], 400);
                    }
                } 
                else {
                    // ✅ अगर प्रोडक्ट simple टाइप का है
                    $price = $product->discountPrice > 0 ? $product->discountPrice : $product->price;
                    $weight = $product->weight;
        
                    if ($product->current_stock < $quantity) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Insufficient stock.',
                        ], 400);
                    }
                }
        
                $total = $price * $quantity;
        
                // ✅ लॉगिन यूज़र
                if ($customerId) {
                    $cartItem = Cart::where('customer_id', $customerId)
                        ->where('product_id', $productId)
                        ->where('size', $size)
                        ->first();
        
                    if ($cartItem) {
                        $cartItem->product_qty += $quantity;
                        $cartItem->total = $cartItem->product_qty * $price;
                        $cartItem->save();
                        $message = 'Product quantity updated in cart!';
                    } else {
                        Cart::create([
                            'customer_id' => $customerId,
                            'product_id' => $productId,
                            'product_qty' => $quantity,
                            'total' => $total,
                            'size' => $size,
                            'weight' => $weight,
                            'variant_id' => $product->product_type == 'variant' ? $variantId : null,
                        ]);
                        $message = 'Product added to cart successfully!';
                    }
                } 
                else {
                    // ✅ Guest User (Session Cart)
                    $cart = session()->get('cart', []);
                    $cartKey = $productId . '-' . $size;
        
                    if (isset($cart[$cartKey])) {
                        $cart[$cartKey]['product_qty'] += $quantity;
                        $cart[$cartKey]['total'] = $cart[$cartKey]['product_qty'] * $price;
                        $message = 'Product quantity updated in cart!';
                    } else {
                        $cart[$cartKey] = [
                            'product_id' => $productId,
                            'product_qty' => $quantity,
                            'price' => $price,
                            'total' => $total,
                            'size' => $size,
                            'weight' => $weight,
                            'variant_id' => $product->product_type == 'variant' ? $variantId : null,
                        ];
                        $message = 'Product added to cart successfully!';
                    }
        
                    session()->put('cart', $cart);
                }
        
                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                ]);
        
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong: ' . $e->getMessage(),
                ], 500);
            }
        }


// -----------------------------------------------------------------------------
        public function updateCart(Request $request)
        {
            $request->validate([
                'id' => 'required|integer',
                'quantity' => 'required|integer|min:1',
            ]);

            $customer_id = Auth::id();

            if ($customer_id) {
                // For logged-in users, update the database cart
                $cartItem = Cart::find($request->id);

                if ($cartItem && $cartItem->customer_id == $customer_id) {
                    $product = $cartItem->product;
                    $cartItem->product_qty = $request->quantity;
                    $cartItem->total = $product->discountPrice * $request->quantity;
                    $cartItem->save();

                    return response()->json(['success' => true]);
                }

                return response()->json(['success' => false, 'message' => 'Invalid cart item.']);
            } else {
                // For guest users, update the session cart
                $cart = Session::get('cart', []);

                foreach ($cart as &$item) {
                    if ($item['product_id'] == $request->id) {
                        $item['product_qty'] = $request->quantity ?? 1;

                        // Optionally, you can also update the product total in session (not necessary for just quantity update)
                        $product = Product::find($request->id);
                        if ($product) {
                            $item['total'] = $product->discountPrice * $item['product_qty'];
                        }

                        break;
                    }
                }

                // Save the updated cart back to the session
                Session::put('cart', $cart);

                return response()->json(['success' => true]);
            }
        }

// -----------------------------------------------------------------------------
    public function updateTotal(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric',
        ]);

        $cartItems = Cart::where('customer_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $cartItem->total = $request->total;
            $cartItem->save();
        }

        return response()->json(['success' => true]);
    }
    // -----------------------------------------------------------------------------


    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $customerId = Auth::id();

        // Eager load relationships to avoid N+1 query problem
        $cartItems = Cart::where('customer_id', $customerId)->with('product.category')->get();
        
        // Add a default value to prevent undefined variable errors
        $discountAmount = 0;
        $message = 'This coupon cannot be applied.';

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty',
            ]);
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->discountPrice ?? $item->product->price;
            return $item->product_qty * $price;
        });

        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code',
            ]);
        }

        // Check coupon validity (date range)
        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has expired',
            ]);
        }

        // 1. UNIVERSAL COUPON
        if ($coupon->is_universal) {
            $discountAmount = ($subtotal * $coupon->discount_percentage) / 100;
            $message = 'Universal coupon applied successfully!';
        }
        // 2. CATEGORY-SPECIFIC COUPON
        elseif ($coupon->category_id) {
            // Corrected: Compare product's category_id with the coupon's category_id
            $applicableItems = $cartItems->filter(function ($item) use ($coupon) {
                return $item->product->category_id == $coupon->category_id;
            });

            if ($applicableItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products in your cart belong to this coupon\'s category.',
                ]);
            }

            $applicableSubtotal = $applicableItems->sum(function ($item) {
                $price = $item->product->discountPrice ?? $item->product->price;
                return $item->product_qty * $price;
            });

            $discountAmount = ($applicableSubtotal * $coupon->discount_percentage) / 100;
            $message = 'Category coupon applied successfully!';
        }
        // 3. PRODUCT-SPECIFIC COUPON
        elseif ($coupon->product_ids) {
            $couponProductIds = is_array($coupon->product_ids)
                ? $coupon->product_ids
                : json_decode($coupon->product_ids, true) ?? [];

            $applicableItems = $cartItems->filter(function ($item) use ($couponProductIds) {
                return in_array($item->product_id, $couponProductIds);
            });

            if ($applicableItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'None of the required products for this coupon are in your cart.',
                ]);
            }

            $applicableSubtotal = $applicableItems->sum(function ($item) {
                $price = $item->product->discountPrice ?? $item->product->price;
                return $item->product_qty * $price;
            });

            $discountAmount = ($applicableSubtotal * $coupon->discount_percentage) / 100;
            $message = 'Product-specific coupon applied to matching products!';
        }
        else {
            // This block now becomes a fallback if coupon type is not set properly
            return response()->json([
                'success' => false,
                'message' => 'This coupon cannot be applied.',
            ]);
        }

        $total = $subtotal - $discountAmount;

        // Store coupon data in session
        session([
            'cart_discount' => $discountAmount,
            'cart_discount_percentage' => $coupon->discount_percentage,
            'applied_coupon' => $coupon->code,
            'total_amount' => $total,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'discount' => round($discountAmount, 2),
            'total' => round($total, 2),
            'discount_percentage' => $coupon->discount_percentage,
        ]);
    }

// -----------------------------------------------------------------------------

public function removeFromCart(Request $request)
{
    $request->validate([
        'id' => 'required|integer', // product_id
        'variant_id' => 'nullable|integer', // optional variant_id for variant products
    ]);

    if (Auth::check()) {
        // Logged-in user
        $cartQuery = Cart::where('id', $request->id)
                        ->where('customer_id', Auth::id());

        if ($request->has('variant_id') && $request->variant_id) {
            $cartQuery->where('variant_id', $request->variant_id);
        }

        $cartItem = $cartQuery->first();

        if ($cartItem) {
            $cartItem->delete();

            // Get updated count
            $count = Cart::where('customer_id', Auth::id())->sum('product_qty');

            return response()->json(['success' => true, 'count' => $count]);
        }
    } else {
        // Guest user (session)
        $cart = Session::get('cart', []);

        $cart = array_filter($cart, function ($item) use ($request) {
            // Remove only matching variant if variant_id exists
            if (isset($request->variant_id) && $request->variant_id) {
                return !(
                    $item['product_id'] == $request->id &&
                    isset($item['variant_id']) &&
                    $item['variant_id'] == $request->variant_id
                );
            } else {
                // Remove simple product or all variants if variant_id not provided
                return $item['product_id'] != $request->id;
            }
        });

        Session::put('cart', $cart);

        // Updated count
        $count = collect($cart)->sum('product_qty');

        return response()->json(['success' => true, 'count' => $count]);
    }

    return response()->json(['success' => false, 'message' => 'Invalid cart item.']);
}

// -----------------------------------------------------------------------------
   public function getCartCount()
{
    if (Auth::check()) {
        $cartCount = Cart::where('customer_id', Auth::id())->count();
    } else {
        // For guest users, count the items in the session
        $cart = Session::get('cart', []);
        $cartCount = count($cart);
    }

    return response()->json(['cartCount' => $cartCount]);
}


// -----------------------------------------------------------------------------
    public function getCartData()
    {
        $freeGift = GiftProduct::first(); // Or apply your own conditions if needed
        return response()->json(['freeGift' => $freeGift]);
    }
// -----------------------------------------------------------------------------

    
                    public function checkout_view()
        {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'You need to log in first to access the checkout page.');
            }

            $this->transferGuestCartToDatabase();

            $user = auth()->user();
            $cartItems = Cart::where('customer_id', $user->id)->with('product')->get();
            $addresses = $user->userAddress;

            // Calculate the subtotal from the cart items
            $subtotal = $cartItems->sum(function ($item) {
                $price = $item->product->discountPrice ?? $item->product->price;
                return $item->product_qty * $price;
            });

            // Initialize variables for discount and final total
            $discountAmount = 0;
            $appliedCoupon = null;
            
            // Check if a coupon discount exists in the session
            if (session()->has('cart_discount')) {
                $discountAmount = session('cart_discount');
                $appliedCoupon = session('applied_coupon');
            }

            // Calculate the total after applying the discount
            $totalAfterDiscount = $subtotal - $discountAmount;
            
            // Pass all necessary data to the view
            return view('checkout', compact(
                'user', 
                'addresses', 
                'cartItems', 
                'subtotal', 
                'discountAmount', 
                'appliedCoupon',
                'totalAfterDiscount'
            ));
        }
            
            public function singleCheckoutView($product_id)
            {
                if (!auth()->check()) {
                    return redirect()->route('login')->with('error', 'Please log in to continue with checkout.');
                }
            
                $user = auth()->user();
                $product = Product::find($product_id);
            
                if (!$product) {
                    return redirect()->back()->with('error', 'Product not found.');
                }
            
                $quantity = 1;
                $cartItems = [
                    (object)[
                        'product_id' => $product->id,
                        'product' => $product,
                        'product_qty' => $quantity,
                        'price' => $product->discountPrice,
                        'total' => $product->discountPrice * $quantity,
                        // 'size' => $product->size,
                        'size' => !empty($product->size) ? $product->size : 'Universal', 
                    ]
                ];
            
                $addresses = $user->userAddress;
                $totalAmount = $cartItems[0]->total; // direct for single checkout
            
                return view('checkout', compact('user', 'addresses', 'cartItems', 'totalAmount'));
            }


// -----------------------------------------------------------------------------
    public function store_address(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        Address::create([
            'user_id' => auth()->id(),
            'full_name' => $request->full_name,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        return redirect()->back()->with('success', 'Address added successfully!');
    }

public function transferGuestCartToDatabase()
{
    if (!Session::has('cart')) {
        return; // No session cart to transfer
    }

    $guestCart = Session::get('cart');
    $customer_id = Auth::id();

    foreach ($guestCart as $item) {
        $existingCartItem = Cart::where('customer_id', $customer_id)
            ->where('product_id', $item['product_id'])
            ->first();

        if ($existingCartItem) {
            // Update the quantity if product already exists in the DB cart
         $existingCartItem->product_qty += $item['product_qty'];
            $existingCartItem->total = $existingCartItem->product_qty * $existingCartItem->product->price; // Update the total
            $existingCartItem->save();
        } else {
            // Create new entry if product does not exist
            Cart::create([
                'product_id' => $item['product_id'],
                'product_qty' => $item['product_qty'],
                'customer_id' => $customer_id,
                'total' => $item['product_qty'] * Product::find($item['product_id'])->price, // Calculate and set total
            ]);
        }
    }

    // Clear session cart after transfer
    Session::forget('cart');
}

public function updateGuestCartCount()
{
    $cart = Session::get('cart', []);
    $count = count($cart);
    return response()->json(['cartCount' => $count]);
}



}
