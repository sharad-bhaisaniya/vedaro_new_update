<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
    // In your PreBookingController.php
use Twilio\Rest\Client;

class PreBookingController extends Controller
{
    
    


public function sendWhatsAppReminder($id)
{
    try {
        $preBooking = PreBooking::with(['user', 'product'])->findOrFail($id);
        
        if (!$preBooking->user || !$preBooking->user->phone) {
            throw new \Exception('User phone number not available');
        }

        $twilio = new Client(
            env('TWILIO_SID'), 
            env('TWILIO_TOKEN')
        );

        $message = $twilio->messages->create(
            "whatsapp:+91{$preBooking->user->phone}", // Indian numbers format
            [
                "from" => "whatsapp:".env('TWILIO_WHATSAPP_NUMBER'),
                "body" => "Hey {$preBooking->user->first_name}, you left 1 x {$preBooking->product->productName} in your cart!\n\nComplete your order: ".route('cart.show')
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp reminder sent successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
    public function store(Request $request, $product_id)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to pre-book a product.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:1000',
        ]);

        PreBooking::create([
            'user_id'    => $user->id,
            'product_id' => $product_id,
            'quantity'   => $request->input('quantity'),
            'email'      => $user->email,
            'phone'      => $user->phone ?? null,
            'note'       => $request->input('note'),
        ]);

        return back()->with('success', 'Product pre-booked successfully!');
    }

    public function index()
    {
        $preBookings = PreBooking::with(['user', 'product'])->latest()->get();
        return view('admin.preBooking', compact('preBookings'));
    }


}