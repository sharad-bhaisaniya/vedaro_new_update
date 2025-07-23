<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAddress;
use App\Models\User;
use App\Models\Cart;


class RazorpayController extends Controller
{
    public function initiatePayment(Request $request)
    {
        try {
            Log::info('🟡 Razorpay payment init request:', $request->all());

            $user = auth()->user();
            $orderIdStr = $request->order_id ?? '#MAHA-' . Str::upper(Str::random(8));
            $amount = (float) $request->amount;
            $amountInPaise = (int) ($amount * 100);

            // 1. Create Order
            $order = new Order();
            $order->order_id = $orderIdStr;
            // $order->txnid = '';
            $order->amount = $amount;
            $order->status = 'Pending';
            $order->full_name = $request->input('full_name') ?? (($user->first_name).' '.($user->last_name) ?? '');
            $order->email = $request->input('email') ?? ($user->email ?? '');
            $order->phone = $request->phone ?? '';
            $order->address = $request->address ?? '';
            $order->city = $request->city ?? '';
            $order->postal_code = $request->postal_code ?? '';
            $order->country = $request->country ?? 'India';
            $order->shipping_address = $request->shipping_address ?? $order->address;
            $order->billing_address = $request->billing_address ?? $order->address;
            $order->razorpay_order_id = '';
            $order->razorpay_payment_id = '';
            $order->awb = '';

            if (!$order->save()) {
                Log::error('❌ Order save failed.');
                return response()->json([
                    'success' => false,
                    'message' => 'Order could not be saved.'
                ], 500);
            }

            // 2. Store Order Items
             // Add items to the order
               $cartItems = $request->input('cartItems');
                if (is_array($cartItems)) {
                    foreach ($cartItems as $cartItem) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->product_id = $cartItem['product_id'];
                        $orderItem->product_qty = $cartItem['quantity'];
                        $orderItem->price = $cartItem['price'];
                        $orderItem->total = $orderItem->product_qty * $orderItem->price;
                        $orderItem->save();
                    }
                } else {
                    Log::warning('No cartItems passed in request.');
                }


            // 3. Create Razorpay Order
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $razorpayOrder = $api->order->create([
                'receipt' => $orderIdStr,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            // 4. Update Razorpay order ID
            $order->razorpay_order_id = $razorpayOrder['id'];
            $order->save();

            Log::info("✅ Razorpay order created", [
                'razorpay_id' => $razorpayOrder['id'],
                'internal_order_id' => $order->id
            ]);

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $amount,
                'currency' => 'INR',
                'key' => env('RAZORPAY_KEY'),
                'order_id' => $orderIdStr
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Payment initiation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment processing error: ' . $e->getMessage()
            ], 500);
        }
    }


       // Payment Verification Method
    // public function verifyPayment(Request $request)
    // {
    //     try {
    //         $data = $request->all();
    //         Log::info('Verify Razorpay Payment Request:', $data);

    //         // Validate required parameters
    //         $required = ['razorpay_signature', 'razorpay_order_id', 'razorpay_payment_id', 'order_id'];
    //         foreach ($required as $field) {
    //             if (empty($data[$field])) {
    //                 throw new \Exception("Missing required field: $field");
    //             }
    //         }

    //         $signature = $data['razorpay_signature'];
    //         $razorpayOrderId = $data['razorpay_order_id'];
    //         $paymentId = $data['razorpay_payment_id'];
    //         $internalOrderId = $data['order_id'];

    //         // Generate signature for verification
    //         $generatedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $paymentId, env('RAZORPAY_SECRET'));

    //         if (hash_equals($generatedSignature, $signature)) {
    //             $order = Order::where('order_id', $internalOrderId)->first();

    //             if (!$order) {
    //                 throw new \Exception("Order not found: $internalOrderId");
    //             }

    //             // Update order status and payment details
    //             $order->update([
    //                 'status' => 'Paid',
    //                 'txnid' => $paymentId,
    //                 'razorpay_order_id' => $razorpayOrderId,
    //                 'razorpay_payment_id' => $paymentId
    //             ]);
    //                // ✅ Clear user's cart after successful payment
    //             Cart::where('customer_id', auth()->id())->delete();


    //             return response()->json([
    //                 'success' => true,
    //                 'order_id' => $internalOrderId,
    //                 'message' => 'Payment verified successfully.'
    //             ]);
    //         } else {
    //             Log::warning('Invalid payment signature', [
    //                 'expected' => $generatedSignature,
    //                 'received' => $signature
    //             ]);

    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Invalid payment signature.'
    //             ], 400);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Razorpay Verify Error: ' . $e->getMessage(), [
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Verification failed: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
        public function verifyPayment(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('Verify Razorpay Payment Request:', $data);

            // Validate required parameters
            $required = ['razorpay_signature', 'razorpay_order_id', 'razorpay_payment_id', 'order_id'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new \Exception("Missing required field: $field");
                }
            }

            $signature = $data['razorpay_signature'];
            $razorpayOrderId = $data['razorpay_order_id'];
            $paymentId = $data['razorpay_payment_id'];
            $internalOrderId = $data['order_id'];

            // Generate signature for verification
            $generatedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $paymentId, env('RAZORPAY_SECRET'));

            if (hash_equals($generatedSignature, $signature)) {
                $order = Order::where('order_id', $internalOrderId)->first();

                if (!$order) {
                    throw new \Exception("Order not found: $internalOrderId");
                }

                // Update order status and payment details
                $order->update([
                    'status' => 'Paid',
                    'txnid' => $paymentId,
                    'razorpay_order_id' => $razorpayOrderId,
                    'razorpay_payment_id' => $paymentId
                ]);
                   // ✅ Clear user's cart after successful payment
                Cart::where('customer_id', auth()->id())->delete();


                return response()->json([
                    'success' => true,
                    'order_id' => $internalOrderId,
                    'message' => 'Payment verified successfully.'
                ]);
            } else {
                Log::warning('Invalid payment signature', [
                    'expected' => $generatedSignature,
                    'received' => $signature
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment signature.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Razorpay Verify Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed: ' . $e->getMessage()
            ], 500);
        }
    }



    public function thankYouPage()
    {
        return view('thanku');
    }
}
