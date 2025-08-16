<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        return view('event_checkout');
    }

  public function initiatePayment(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'email' => 'required|email',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'address' => 'required|string',
        'city' => 'required|string',
        'pincode' => 'required|string',
        'state' => 'required|string',
        'country' => 'required|string',
        'phone' => 'required|string',
    ]);

    // Create Razorpay order
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
    $orderData = [
        'receipt' => 'order_'.time(),
        'amount' => 5100, // ₹51.00 in paise
        'currency' => 'INR',
        'payment_capture' => 1 // auto capture payment
    ];

    $razorpayOrder = $api->order->create($orderData);

    // Create event record with payment_status as pending
    $event = Event::create([
        'user_id' => Auth::id(),
        'email' => $validated['email'],
        'first_name' => $validated['first_name'],
        'last_name' => $validated['last_name'],
        'address' => $validated['address'],
        'city' => $validated['city'],
        'pincode' => $validated['pincode'],
        'state' => $validated['state'],
        'country' => $validated['country'],
        'phone' => $validated['phone'],
        'payment_status' => 'pending',
        'razorpay_order_id' => $razorpayOrder['id'] // Make sure this is saved
    ]);

    return response()->json([
        'success' => true,
        'order_id' => $razorpayOrder['id'],
        'amount' => $orderData['amount'],
        'event_id' => $event->id,
        'key' => env('RAZORPAY_KEY')
    ]);
}

public function verify(Request $request)
{
    try {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];
        
        $api->utility->verifyPaymentSignature($attributes);

        // Update event payment status
        $event = Event::where('razorpay_order_id', $request->razorpay_order_id)->first();
        
        if ($event) {
            $event->update([
                'payment_status' => 'paid',
                'razorpay_payment_id' => $request->razorpay_payment_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'event_id' => $event->id
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Event not found'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Payment verification failed: ' . $e->getMessage()
        ]);
    }
}




    // New methods for showing bookings
    public function showBookings()
    {
        $bookings = Event::where('payment_status', 'paid')
                        ->with('user') // If you have user relationship
                        ->latest()
                        ->paginate(10);

        return view('admin.Events.event_booking', compact('bookings'));
    }

    public function showBooking(Event $event)
    {
        return view('events.booking-show', compact('event'));
    }

    public function destroyBooking(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }
}





