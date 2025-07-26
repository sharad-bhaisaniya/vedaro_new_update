<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShiprocketOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller

{
    // In your OrderController or a dedicated controller for orders


public function myOrders()
{
    try {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view your orders.');
        }

        // ✅ Fetch orders with order items and products
        $orders = Order::with(['items.product'])
            ->where('phone', $user->phone)
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('📦 Orders loaded for user:', [
            'phone' => $user->phone,
            'order_count' => $orders->count()
        ]);

        return view('my_orders', compact('orders'));

    } catch (\Exception $e) {
        Log::error('❌ Error loading my orders: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to load your orders.');
    }
}




    public function orderStatus($orderId)
    {
        $order = Order::with(['items.product'])->where('id', $orderId)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        return view('order_status', compact('order'));
    }




// ----------------------------------------Adimn Orders view--------------------------------
//  public function completedOrders()
//     {
//         $orders = Order::with('items')->where('status', 'Paid')->get();
//         return view('admin.completed_orders', compact('orders'));
//     }

     

public function completedOrders()
{
    // 1. Local Orders (status = 'Paid' and not canceled)
    $localOrders = Order::with('items')
        ->where('status', 'Paid')
        ->where(function($query) {
            $query->where('status', '!=', 'canceled')
                  ->orWhereNull('status'); // Include if status is null
        })
        ->get();

    // 2. Shiprocket Orders
    $token = $this->getShiprocketToken();
    $shiprocketOrders = [];

    if ($token) {
        $url = 'https://apiv2.shiprocket.in/v1/external/orders';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get($url, [
            'per_page' => 100,
            'sort' => 'desc'
        ]);

        $orders = $response->json();

        if (isset($orders['data']) && !empty($orders['data'])) {
            foreach ($orders['data'] as $order) {
                // Skip canceled orders
                if (isset($order['status']) && strtolower($order['status']) === 'canceled') {
                    continue;
                }

                $shipment = $order['shipments'][0] ?? [];

                // Process Shiprocket products
                $orderItems = [];
                foreach ($order['products'] ?? [] as $product) {
                    $orderItems[] = [
                        'name' => $product['name'] ?? 'N/A',
                        'sku' => $product['channel_sku'] ?? $product['sku'] ?? 'N/A',
                        'price' => $product['price'] ?? '0.00',
                        'quantity' => $product['quantity'] ?? 0,
                        'total' => ($product['price'] ?? 0) * ($product['quantity'] ?? 0)
                    ];
                }

                $shiprocketOrders[] = [
                    'order_id' => $order['id'] ?? null,
                    'channel_order_id' => $order['channel_order_id'] ?? 'N/A',
                    'order_date' => isset($order['created_at']) 
                        ? \Carbon\Carbon::parse($order['created_at'])->format('d M Y, h:i A')
                        : 'N/A',
                    'customer_name' => $order['customer_name'] ?? 'Unknown',
                    'status' => $order['status'] ?? 'Pending',
                    'payment_method' => $order['payment_method'] ?? 'N/A',
                    'order_total' => $order['total'] ?? '0.00',
                    'tracking_url' => isset($shipment['awb']) 
                        ? "https://shiprocket.co/tracking/" . $shipment['awb'] 
                        : null,
                    'courier_name' => $shipment['courier'] ?? null,
                    'order_items' => $orderItems,
                    'shipping_address' => [
                        'address' => $order['customer_address'] ?? 'N/A',
                        'city' => $order['customer_city'] ?? 'N/A',
                        'state' => $order['customer_state'] ?? 'N/A',
                        'pincode' => $order['customer_pincode'] ?? 'N/A'
                    ]
                ];
            }
        }
    }

    // 3. Return both to the view
    return view('admin.completed_orders', [
        'localOrders' => $localOrders,
        'shiprocketOrders' => $shiprocketOrders
    ]);
}





    public function pendingOrders()
    {
        $orders = Order::with('items')->where('status', 'Paid')->get();
        return view('admin.pending_orders', compact('orders'));
    }
    
    public function canceledOrders()
{
    // 1. Local Canceled Orders (ONLY checks 'status' field)
    $localCanceledOrders = Order::with('items')
        ->where(function($query) {
            $query->where('status', 'Canceled') // Exact match
                  ->orWhere('status', 'like', '%cancel%'); // Broad match (e.g., "Cancelled")
        })
        ->get();

    // 2. Shiprocket Canceled Orders (ONLY checks 'status' field)
    $token = $this->getShiprocketToken();
    $shiprocketCanceledOrders = [];

    if ($token) {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://apiv2.shiprocket.in/v1/external/orders', [
            'per_page' => 100,
            'sort' => 'desc',
        ]);

        $orders = $response->json();

        if (isset($orders['data']) && !empty($orders['data'])) {
            foreach ($orders['data'] as $order) {
                // Skip if status is not "canceled" (case-insensitive)
                if (!isset($order['status']) || strtolower($order['status']) !== 'canceled') {
                    continue;
                }

                $shipment = $order['shipments'][0] ?? [];
                $orderItems = [];

                foreach ($order['products'] ?? [] as $product) {
                    $orderItems[] = [
                        'name' => $product['name'] ?? 'N/A',
                        'sku' => $product['channel_sku'] ?? $product['sku'] ?? 'N/A',
                        'price' => $product['price'] ?? '0.00',
                        'quantity' => $product['quantity'] ?? 0,
                        'total' => ($product['price'] ?? 0) * ($product['quantity'] ?? 0),
                    ];
                }

                $shiprocketCanceledOrders[] = [
                    'order_id' => $order['id'] ?? null,
                    'channel_order_id' => $order['channel_order_id'] ?? 'N/A',
                    'order_date' => isset($order['created_at']) 
                        ? \Carbon\Carbon::parse($order['created_at'])->format('d M Y, h:i A')
                        : 'N/A',
                    'customer_name' => $order['customer_name'] ?? 'Unknown',
                    'status' => $order['status'] ?? 'Canceled',
                    'payment_method' => $order['payment_method'] ?? 'N/A',
                    'order_total' => $order['total'] ?? '0.00',
                    'tracking_url' => isset($shipment['awb']) 
                        ? "https://shiprocket.co/tracking/" . $shipment['awb'] 
                        : null,
                    'courier_name' => $shipment['courier'] ?? null,
                    'order_items' => $orderItems,
                    'shipping_address' => [
                        'address' => $order['customer_address'] ?? 'N/A',
                        'city' => $order['customer_city'] ?? 'N/A',
                        'state' => $order['customer_state'] ?? 'N/A',
                        'pincode' => $order['customer_pincode'] ?? 'N/A',
                    ],
                ];
            }
        }
    }

    return view('admin.canceled_orders', [
        'localCanceledOrders' => $localCanceledOrders,
        'orders' => $shiprocketCanceledOrders,
    ]);
}




// -----------------------------------------Ship Rocket Code-------------------------------------------------------

    private function getShiprocketToken()
    {
        $url = 'https://apiv2.shiprocket.in/v1/external/auth/login';

        $data = [
            'email' => 'bhudhote998@gmail.com',
            'password' => '1998@Bhup'
        ];

        $headers = [
            'Content-Type: application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response, true);

        if (isset($response['token'])) {
            return $response['token'];
        }

        return null;
    }



  public function shipOrder(Request $request)
{
    $orderId = $request->input('order_id');
    $order = Order::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found!',
            'order_id' => $orderId
        ]);
    }

    $shiprocketToken = $this->getShiprocketToken();
    if (!$shiprocketToken) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to authenticate with Shiprocket API.'
        ]);
    }

    $response = $this->createShiprocketOrder($order, $shiprocketToken);

    Log::info('Shiprocket API Response:', $response);

    if ($response && isset($response['status_code']) && $response['status_code'] == 1) {
        $order->status = 'Shipped';
        $order->save();  // Save the updated order in the database

        return response()->json([
            'success' => true,
            'message' => 'Order shipped successfully!',
            'response' => $response
        ]);
    } else {
        $errorMessage = isset($response['errors']) ? $response['errors'] : 'Unknown error';
        Log::error('Failed to ship the order', ['response' => $response, 'error_message' => $errorMessage]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to ship the order!',
            'errors' => $errorMessage,
            'response' => $response
        ]);
    }
}


private function createShiprocketOrder($order, $token)
{
    $url = 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc';

    $billingAddress = $order->billing_address ?? 'Default Billing Address';
    $shippingAddress = $order->shipping_address ?? 'Default Shipping Address';

    $billingCity = $order->city ?? 'Default City';
    $billingPostalCode = $order->postal_code ?? '000000';
    $billingState = $order->state ?? 'Default State';
    $billingCountry = $order->country ?? 'India';

    $hsnCode = '';

    // Default dimensions in case product has no size info
    $length = 10;
    $breadth = 10;
    $height = 10;

    $totalWeight = 0; // Track total weight dynamically
    $data['order_items'] = [];

    foreach ($order->items as $orderItem) {
        $product = $orderItem->product;

        // Set dimensions from size field (e.g. "10 x 5 x 3")
        $size = $product->size ?? '';
        if ($size) {
            $dimensions = explode(' x ', $size);
            if (count($dimensions) === 3) {
                $length = (float) $dimensions[0];
                $breadth = (float) $dimensions[1];
                $height = (float) $dimensions[2];
            }
        }

        // Weight from DB * quantity
        $productWeight = $product->weight ?? 0.5; // fallback to 0.5 kg
        $totalWeight += ($productWeight * $orderItem->product_qty);

        // Add order item
        $data['order_items'][] = [
            'name' => $product->productName,
            'sku' => $product->coupon_code,
            'units' => $orderItem->product_qty,
            'selling_price' => $orderItem->price,
            'discount' => '',
            'tax' => '',
            'hsn' => $hsnCode
        ];
    }

    // Prepare final payload
    $data = [
        'order_id' => $order->order_id,
        'order_date' => $order->created_at->format('Y-m-d H:i'),
        'pickup_location' => 'Primary',
        'billing_customer_name' => $order->full_name,
        'billing_last_name' => '',
        'billing_address' => $billingAddress,
        'billing_city' => $billingCity,
        'billing_pincode' => $billingPostalCode,
        'billing_state' => $billingState,
        'billing_country' => $billingCountry,
        'billing_email' => $order->email,
        'billing_phone' => $order->phone,
        'shipping_is_billing' => true,
        'order_items' => $data['order_items'],
        'payment_method' => 'Prepaid',
        'sub_total' => $order->amount,
        'length' => $length,
        'breadth' => $breadth,
        'height' => $height,
        'weight' => $totalWeight
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}


public function fetchShiprocketOrders()
{
    $token = $this->getShiprocketToken();
    if (!$token) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to authenticate with Shiprocket API.'
        ]);
    }

    $url = 'https://apiv2.shiprocket.in/v1/external/orders';
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token
    ])->get($url, [
        'per_page' => 100, // Get more orders if needed
        'sort' => 'desc' // Newest first
    ]);

    $orders = $response->json();

    if (!isset($orders['data']) || empty($orders['data'])) {
        return response()->json([
            'success' => false,
            'message' => 'No orders found or invalid response.',
            'response' => $orders
        ]);
    }

    $loggedInUserEmail = Auth::user()->email;
    $processedOrders = [];

    foreach ($orders['data'] as $order) {
        if (($order['customer_email'] ?? null) !== $loggedInUserEmail) {
            continue;
        }

        $shipment = $order['shipments'][0] ?? [];
        
        // Process all products/order items
        $orderItems = [];
        foreach ($order['products'] ?? [] as $product) {
            $orderItems[] = [
                'name' => $product['name'] ?? 'N/A',
                'sku' => $product['channel_sku'] ?? $product['sku'] ?? 'N/A',
                'price' => $product['price'] ?? '0.00',
                'quantity' => $product['quantity'] ?? 0,
                'total' => ($product['price'] ?? 0) * ($product['quantity'] ?? 0)
            ];
        }

        $processedOrders[] = [
            'order_id' => $order['id'] ?? null,
            'channel_order_id' => $order['channel_order_id'] ?? 'N/A',
            'order_date' => isset($order['created_at']) 
                ? \Carbon\Carbon::parse($order['created_at'])->format('d M Y, h:i A')
                : 'N/A',
            'customer_name' => $order['customer_name'] ?? 'Unknown',
            'status' => $order['status'] ?? 'Pending',
            'payment_method' => $order['payment_method'] ?? 'N/A',
            'order_total' => $order['total'] ?? '0.00',
            'tracking_url' => isset($shipment['awb']) 
                ? "https://shiprocket.co/tracking/" . $shipment['awb'] 
                : null,
            'courier_name' => $shipment['courier'] ?? null,
            'order_items' => $orderItems,
            'shipping_address' => [
                'address' => $order['customer_address'] ?? 'N/A',
                'city' => $order['customer_city'] ?? 'N/A',
                'state' => $order['customer_state'] ?? 'N/A',
                'pincode' => $order['customer_pincode'] ?? 'N/A'
            ]
        ];
    }

    return view('fetch-shiprocket-orders', compact('processedOrders'));
}

public function updateShipmentStatus($orderId)
{
    $order = Order::find($orderId);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $shipmentResponse = [
        'shipment_id' => 'SR123456789' // Example AWB number
    ];

    if (isset($shipmentResponse['shipment_id'])) {
        $order->awb = $shipmentResponse['shipment_id'];
        $order->status = 'Shipped';
        $order->save();

        return response()->json(['message' => 'Order updated with AWB', 'awb' => $order->awb], 200);
    }

    return response()->json(['message' => 'Failed to update order with AWB'], 500);
}

public function trackOrder(Request $request)
{
    if (!$request->order_id || !$request->awb) {
        return response()->json([
            'success' => false,
            'message' => 'Missing order ID or AWB number'
        ]);
    }

    $token = $this->getShiprocketToken();
    if (!$token) {
        return response()->json(['success' => false, 'message' => 'Failed to authenticate with ShipRocket']);
    }

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
    ])->get("https://apiv2.shiprocket.in/v1/external/courier/track/awb/{$request->awb}");

    $trackingData = $response->json();

    if (!$trackingData || !isset($trackingData['tracking_data'])) {
        return response()->json([
            'success' => false,
            'message' => 'Tracking details not available.'
        ]);
    }

    return response()->json([
        'success' => true,
        'data' => $trackingData['tracking_data'],
        'tracking_url' => "https://shiprocket.co/tracking/{$request->awb}"
    ]);
}






public function cancelShiprocketOrder(Request $request)
{
    $request->validate([
        'order_id' => 'required|integer'
    ]);

    $orderId = $request->order_id;
    $token = $this->getShiprocketToken(); // Ensure this method is working

    if (!$token) {
        return response()->json(['success' => false, 'message' => 'Failed to authenticate with Shiprocket API.']);
    }

    $url = "https://apiv2.shiprocket.in/v1/external/orders/cancel";
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Content-Type'  => 'application/json'
    ])->post($url, [
        'ids' => [$orderId]
    ]);

    $result = $response->json();

    if ($response->successful()) {
        return response()->json(['success' => true, 'message' => 'Order cancelled successfully.']);
    } else {
        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to cancel order.',
            'response' => $result
        ]);
    }
}







}
