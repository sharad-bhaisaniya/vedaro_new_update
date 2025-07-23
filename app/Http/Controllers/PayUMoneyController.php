<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\UserAddress;
use App\Models\User;

class PayUMoneyController extends Controller
{
    
public function payUMoneyView(Request $request)
{
    // Log the request data
    \Log::info($request->all());

    // Validate the user input for address-related fields
    $validated = $request->validate([
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'phone' => 'required|string',
    ]);

    // Update the user's address details
    $user = Auth::user();
    $user->update([
        'address' => $validated['address'],
        'city' => $validated['city'],
        'postal_code' => $validated['postal_code'],
        'phone' => $validated['phone'],
    ]);

    // Generate a transaction ID for PayU
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    session(['txnid' => $txnid]);

    // Create a new order
    $order = new Order();
    $order->order_id = '#MAHA-' . Str::random(10);
    $order->txnid = $txnid;
    $order->full_name = $request->input('firstname');
    $order->email = $request->input('email');
    $order->phone = $request->input('phone');
    $order->amount = $request->input('amount');
    $order->status = 'Pending';
    $order->address = $user->address;
    $order->city = $user->city;
    $order->postal_code = $user->postal_code;
    $order->country = $user->country;
    $order->shipping_address = $user->address . ', ' . $user->city . ', ' . $user->postal_code . ', ' . $user->country;
    $order->billing_address = $user->address . ', ' . $user->city . ', ' . $user->postal_code . ', ' . $user->country;

    // Save the order
    $order->save();

    // Add items to the order
    foreach ($request->input('cartItems') as $cartItem) {
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $cartItem['product_id'];
        $orderItem->product_qty = $cartItem['quantity'];
        $orderItem->price = $cartItem['price'];
        $orderItem->total = $cartItem['total'];
        $orderItem->save();
    }

    // PayU configuration
    $MERCHANT_KEY = "mtpuht";
    $SALT = "vv0HaXMfTneW3aTvJrXpxbxDqbBLUggT";
    $PAYU_BASE_URL = "https://secure.payu.in/_payment";

    $name = $request->input('firstname', '');
    $email = $request->input('email', '');
    $phone = $request->input('phone', '');
    $amount = $request->input('amount', '');
    $successURL = route('pay.u.response');
    $failURL = route('pay.u.cancel');

    // Prepare data to send to PayU
    $posted = [
        'key' => $MERCHANT_KEY,
        'txnid' => $txnid,
        'amount' => $amount,
        'productinfo' => 'Webappfix',
        'firstname' => $name,
        'email' => $email,
        'phone' => $phone,
        'surl' => $successURL,
        'furl' => $failURL,
        'service_provider' => 'payu_paisa',
        'udf1' => '',
        'udf2' => '',
        'udf3' => '',
        'udf4' => '',
        'udf5' => '',
    ];

    // Generate PayU hash string
    $hash_string = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $posted['productinfo'] . '|' . $name . '|' . $email . '|' .
        $posted['udf1'] . '|' . $posted['udf2'] . '|' . $posted['udf3'] . '|' . $posted['udf4'] . '|' . $posted['udf5'] . '||||||' . $SALT;

    $hash = strtolower(hash('sha512', $hash_string));

    // Log the PayU hash details
    \Log::info("PayU Hash String: {$hash_string}");
    \Log::info("PayU Hash: {$hash}");

    // Define the action URL
    $action = $PAYU_BASE_URL . '/_payment';

    // Return the PayU payment view
    return view('pay-u', compact('action', 'hash', 'MERCHANT_KEY', 'txnid', 'successURL', 'failURL', 'name', 'email', 'phone', 'amount'));
}




public function payUResponse(Request $request)
{
    $input = $request->all();

    $txnid = session('txnid'); // Retrieve txnid from session
    if (!$txnid) {
        return redirect('/cart')->with('error', 'Transaction ID not found in session.');
    }

    $MERCHANT_KEY = "mtpuht";
    $SALT = "vv0HaXMfTneW3aTvJrXpxbxDqbBLUggT";

    $status = $input['status'] ?? null;
    $posted_hash = $input['hash'] ?? null;
    $txnid_response = $input['txnid'] ?? null;

    if (!$status || !$posted_hash || !$txnid_response) {
        return redirect('/cart')->with('error', 'Required parameters are missing.');
    }

    if ($txnid != $txnid_response) {
        return redirect('/cart')->with('error', 'Transaction ID mismatch.');
    }

    $retHashSeq = $SALT . '|' . $status . '||||||' . $input['udf5'] . '|' . $input['udf4'] . '|' . $input['udf3'] . '|' . $input['udf2'] . '|' . $input['udf1'] . '|' . $input['email'] . '|' . $input['firstname'] . '|' . $input['productinfo'] . '|' . $input['amount'] . '|' . $txnid . '|' . $MERCHANT_KEY;
    $calculated_hash = strtolower(hash('sha512', $retHashSeq));

    if ($posted_hash !== $calculated_hash) {
        return redirect('/cart')->with('error', 'Hash mismatch. Possible tampering detected.');
    }

    // Find the order by txnid
    $order = Order::where('txnid', $txnid)->first();
    if ($order) {
        if ($status === 'success') {
            // Update order status to "Paid"
            $order->status = 'Paid';
            $order->save();

            // Clear the cart
            if (Auth::check()) {
                // Logged-in user: Clear the cart in the database
                $customer_id = Auth::id();
                \App\Models\Cart::where('customer_id', $customer_id)->delete();
            } else {
                // Guest user: Clear the cart in the session
                session()->forget('cart');
            }

            session()->forget('txnid'); // Clear transaction ID from the session

            return redirect()->route('thanku', ['order_id' => $order->order_id]);
        } elseif ($status === 'failure') {
            // Update order status to "Failed"
            $order->status = 'Failed';
            $order->save();

            return redirect('/cart')->with('error', 'Payment failed. Please try again.');
        } elseif ($status === 'pending') {
            // Update order status to "Pending" in case of issues
            $order->status = 'Pending';
            $order->save();

            return redirect('/cart')->with('error', 'Payment is pending. Please check your payment method.');
        }
    }

    return redirect('/cart')->with('error', 'Order not found. Unable to update status.');
}


public function payUCancel(Request $request)
{
    try {
        \Log::info('PayU Cancel Callback:', $request->all());

        $txnid = session('txnid') ?? $request->input('txnid');

        if (!$txnid) {
            return redirect('/cart')->with('error', 'Transaction ID not found.');
        }

        $order = Order::where('txnid', $txnid)->first();

        if ($order) {
            $order->status = 'Canceled'; // Update status to 'Canceled'
            $order->save();

            session()->forget(['txnid', 'payment_status']);

            return redirect('/cart')->with('error', 'Payment was cancelled successfully.');
        }

        return redirect('/cart')->with('error', 'Order not found for the given Transaction ID.');
    } catch (\Exception $e) {
        \Log::error('Error in PayU Cancel: ' . $e->getMessage());

        return redirect('/cart')->with('error', 'An error occurred while processing the cancellation. Please try again.');
    }
}

}
