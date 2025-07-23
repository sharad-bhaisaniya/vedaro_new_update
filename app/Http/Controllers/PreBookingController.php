<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreBooking;
use Illuminate\Support\Facades\Auth;

class PreBookingController extends Controller
{
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

// app/Http/Controllers/PreBookingController.php
public function index()
{
    $preBookings = PreBooking::with(['user', 'product'])->latest()->get();
    return view('admin.preBooking', compact('preBookings'));
}

}
