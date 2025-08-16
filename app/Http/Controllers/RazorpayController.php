<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Services\AiSensyService;
use Illuminate\Support\Facades\Auth;


class RazorpayController extends Controller
{
    public function initiatePayment(Request $request)
    {
        try {
            Log::info('🟡 Razorpay payment init request:', $request->all());

            $user = auth()->user();
            $orderIdStr = $request->order_id ?? '#VED-' . Str::upper(Str::random(8));
            $amount = (float) $request->amount;
            $amountInPaise = (int) ($amount * 100);

            // 1. Create Order
            $order = new Order();
            $order->order_id = $orderIdStr;
            $order->amount = $amount;
            $order->status = 'Pending';
            $order->full_name = $request->input('full_name') ?? (($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
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

            // 2. Save cart items into OrderItems
            $customer_id = Auth::id();
        // Fetch cart items with product details
        $cartItems = Cart::with('product')
            ->where('customer_id', $customer_id)
            ->get();
        
        if ($cartItems->isNotEmpty()) {
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product; // Already loaded via `with('product')`
                if (!$product) {
                    Log::warning("⚠️ Product not found for ID: " . $cartItem->product_id);
                    continue;
                }
        
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem->product_id;
                $orderItem->product_qty = $cartItem->product_qty;
                $orderItem->price = $product->discountPrice ?? $product->price ?? 0;
                $orderItem->total = $orderItem->product_qty * $orderItem->price;
        
                // ✅ Access size correctly (since $cartItem is an Eloquent model)
                // $orderItem->size = $cartItem->size ?? null; // Use ->size (not ['size'])
                  $orderItem->size = !empty($cartItem->size) ? $cartItem->size : 'Universal';
        
                $orderItem->weight = $product->weight;
                $orderItem->save();
        
                // Optional: Delete cart item after moving to order
                // $cartItem->delete();
            }
        } else {
            Log::warning('Cart is empty for customer ID: ' . $customer_id);
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

    public function verifyPayment(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('Verify Razorpay Payment Request:', $data);

            // Required fields
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

            $generatedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $paymentId, env('RAZORPAY_SECRET'));

            if (hash_equals($generatedSignature, $signature)) {
                $order = Order::where('order_id', $internalOrderId)->first();
                if (!$order) {
                    throw new \Exception("Order not found: $internalOrderId");
                }

                // Update order
                $order->update([
                    'status' => 'Paid',
                    'txnid' => $paymentId,
                    'razorpay_order_id' => $razorpayOrderId,
                    'razorpay_payment_id' => $paymentId
                ]);
                
            
             foreach ($order->items as $item) {
                $product = $item->product;
            
                if (!$product) {
                    Log::error("Product not found for order item ID: {$item->id}");
                    continue;
                }
            
                $orderedQty = (int) $item->product_qty;
                $orderedSize = (string) $item->size;
            
                // Decode size_stock safely
                $sizeStock = json_decode($product->size_stock, true);
            
                // 🔹 If no size or size_stock is empty → use universal stock
                if (empty($orderedSize) || !is_array($sizeStock) || empty($sizeStock)) {
                    if ($product->current_stock < $orderedQty) {
                        Log::warning("❌ Insufficient universal stock for Product ID: {$product->id}");
                        continue;
                    }
            
                    $newStock = $product->current_stock - $orderedQty;
            
                    $product->update([
                        'current_stock' => $newStock
                    ]);
            
                    Log::info("✅ Universal stock updated: Product ID {$product->id}, New Stock: {$newStock}");
                    continue;
                }
            
                // 🔹 Handle size-based stock
                if (!array_key_exists($orderedSize, $sizeStock)) {
                    Log::warning("❌ Ordered size '{$orderedSize}' not found in size_stock for Product ID: {$product->id}");
                    continue;
                }
            
                if ((int)$sizeStock[$orderedSize] < $orderedQty) {
                    Log::warning("❌ Insufficient stock for size '{$orderedSize}' of Product ID: {$product->id}");
                    continue;
                }
            
                // Subtract ordered quantity from size stock
                $sizeStock[$orderedSize] -= $orderedQty;
            
                // 🔄 Recalculate current_stock from updated size_stock
                $newCurrentStock = array_sum($sizeStock);
            
                // Save updated size_stock and current_stock to DB
                $product->update([
                    'size_stock'    => json_encode($sizeStock),
                    'current_stock' => $newCurrentStock,
                ]);
            
                Log::info("✅ Size stock updated: Product ID {$product->id}, Size: {$orderedSize}, New Qty: {$sizeStock[$orderedSize]}, Total Stock: {$newCurrentStock}");
            }
            

          

                // Clear cart
                Cart::where('customer_id', auth()->id())->delete();
                

                // ✅ Send WhatsApp confirmation
                app(AiSensyService::class)->sendOrderConfirmation($order->phone, $order->order_id);

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
