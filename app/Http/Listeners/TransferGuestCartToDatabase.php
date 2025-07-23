<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class TransferGuestCartToDatabase
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        // Check if the user had any cart data stored in the session
        if (Session::has('cart')) {
            // Retrieve the guest cart items from the session
            $guestCartItems = Session::get('cart', []);

            foreach ($guestCartItems as $item) {
                // Retrieve the product from the database to get the price
                $product = Product::find($item['product_id']);

                if ($product) {
                    // Transfer each cart item to the database and associate it with the logged-in user
                    Cart::create([
                        'customer_id' => $user->id, // Associate the cart with the logged-in user
                        'product_id' => $item['product_id'],
                        'product_qty' => $item['product_qty'],
                        'total' => $item['product_qty'] * $product->price, // Calculate and set total
                    ]);
                }
            }

            // After transferring the cart items, remove them from the session
            Session::forget('cart');
        }
    }
}
