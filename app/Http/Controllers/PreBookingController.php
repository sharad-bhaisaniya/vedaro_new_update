<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreBooking;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; // ✅ This line ensures Controller is recognized

class PreBookingController extends Controller
{
    /**
     * Store a new pre-booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product_id
     * @return \Illuminate\Http\RedirectResponse
     */
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
}

