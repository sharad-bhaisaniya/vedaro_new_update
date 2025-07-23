<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;

class UserAddressController extends Controller
{
public function store(Request $request)
{
    // Validate the form input
    $validated = $request->validate([
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'postal_code' => 'required|string|max:20',
        'country' => 'nullable|string|max:100',
        'is_default' => 'nullable|boolean',
    ]);

    // If 'Make it Default' is checked, unset other default addresses for the user
    if ($request->has('is_default') && $request->is_default) {
        UserAddress::where('user_id', auth()->id())->update(['is_default' => false]);
    }

    // Save the data to the database
    UserAddress::create([
        'user_id' => auth()->id(), // Assuming the user is logged in
        'address' => $validated['address'],
        'city' => $validated['city'],
        'postal_code' => $validated['postal_code'],
        'country' => $validated['country'] ?? 'India', // Default value
        'is_default' => $request->has('is_default') ? true : false,
    ]);

    // Redirect with success message
    return redirect()->back()->with('success', 'Address saved successfully!');
}


public function showForm()
{
    $addresses = UserAddress::where('user_id', auth()->id())->get();
    $defaultAddress = UserAddress::where('user_id', auth()->id())->where('is_default', 1)->first();

    return view('addresses.form', compact('addresses', 'defaultAddress'));
}


}
