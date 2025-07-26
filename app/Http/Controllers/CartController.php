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


class CartController extends Controller
{

public function cart_view()
{
    $cartItems = [];
    $subtotal = 0;
    $shippingCost = 18.00; // Example shipping cost

    if (Auth::check()) {
        // For logged-in users, get cart items from the database
        $customer_id = Auth::id();
        $cartItems = Cart::with('product')
            ->where('customer_id', $customer_id)
            ->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product ? $item->product->price * $item->product_qty : 0;
        });
    } else {
        // For guests, get cart items from the session
        $cartItems = Session::get('cart', []);
        foreach ($cartItems as &$item) {
            // Get product data for each item from the database using product_id
            $product = Product::find($item['product_id']);
            if ($product) {
                $item['product'] = $product; // Attach product details to each cart item
                $subtotal += $product->discountPrice * $item['product_qty'];
            }
        }
    }

    $total = $subtotal + $shippingCost;

    return view('cart', [
        'cartItems' => $cartItems,
        'subtotal' => $subtotal,
        'shippingCost' => $shippingCost,
        'total' => $total,
    ]);
}

// -----------------------------------------------------------------------------
public function addToCart(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer',
        'product_qty' => 'required|integer|min:1',
    ]);

    $product_id = $request->input('product_id');
    $product_qty = $request->input('product_qty');
    $customer_id = Auth::id();

    if ($customer_id) {
        // For logged-in users, store in the database
        $existingCartItem = Cart::where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->product_qty += $product_qty;
            $existingCartItem->save();
        } else {
            Cart::create([
                'product_id' => $product_id,
                'product_qty' => $product_qty,
                'customer_id' => $customer_id,
            ]);
        }

        // Check if there's a session cart (for guest users before login)
        $guestCart = Session::get('cart', []);
        if (!empty($guestCart)) {
            foreach ($guestCart as $item) {
                // Migrate the session cart to the database
                Cart::create([
                    'product_id' => $item['product_id'],
                    'product_qty' => $item['product_qty'],
                    'customer_id' => $customer_id,
                ]);
            }

            // Clear the session cart
            Session::forget('cart');
        }

    } else {
        // For guest users, store in session
        $cart = Session::get('cart', []);

        // Check if product already exists in the cart
        $productFound = false;
        foreach ($cart as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['product_qty'] += $product_qty;
                $productFound = true;
                break;
            }
        }

        // If product not found, add it to the cart
        if (!$productFound) {
            $cart[] = [
                'product_id' => $product_id,
                'product_qty' => $product_qty,
            ];
        }

        Session::put('cart', $cart);
    }

    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Product added to cart successfully!']);
    }

    return redirect()->back()->with('success', 'Product added to cart successfully!');
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
                $item['product_qty'] = $request->quantity;

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
    $discount = 0;
    $message = 'Invalid coupon code';

    if ($couponCode == 'DISCOUNT10') {
        $discount = 10; // 10% discount
        $message = 'Coupon applied successfully!';
    }

    $cartItems = Cart::where('customer_id', Auth::id())->with('product')->get();
    $subtotal = $cartItems->sum(function ($item) {
        return $item->product_qty * $item->product->price;
    });

    $shippingCost = 18.00; // Flat shipping cost
    $total = $subtotal + $shippingCost; // Total before applying discount

    // Apply the discount
    $discountAmount = ($subtotal * $discount) / 100;
    $total -= $discountAmount;

    return response()->json([
        'success' => true,
        'message' => $message,
        'discount' => $discountAmount,
        'total' => number_format($total, 2), // Send the new total with the discount
    ]);
}

// -----------------------------------------------------------------------------
    // Remove item from cart
public function removeFromCart(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
    ]);

    if (Auth::check()) {
        // For logged-in users, delete from the database
        $cartItem = Cart::where('id', $request->id)->where('customer_id', Auth::id())->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true]);
        }
    } else {
        // For guest users, delete from the session
        $cart = Session::get('cart', []);
        $cart = array_filter($cart, function ($item) use ($request) {
            return $item['product_id'] != $request->id;
        });
        Session::put('cart', $cart);

        return response()->json(['success' => true]);
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

    // This ensures the guest cart is merged with the user's cart when they log in
    $this->transferGuestCartToDatabase(); // Merge the session cart

    $user = auth()->user();

    // Fetching cart items associated with the logged-in user
    $cartItems = Cart::where('customer_id', $user->id)->with('product')->get();

    // Fetch addresses from the user_addresses table (using UserAddress model)
    $addresses = $user->userAddress; // Correct relationship name for UserAddress

    // Return the data to the view
    return view('checkout', compact('user', 'addresses', 'cartItems'));
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
            'price' => $product->selling_price,
            'total' => $product->selling_price * $quantity,
        ]
    ];

    $addresses = $user->userAddress;

    return view('checkout', compact('user', 'addresses', 'cartItems'));
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
