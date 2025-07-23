<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // ✅ THIS LINE MUST BE OUTSIDE THE CLASS


class AddressController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|numeric',
    ]);

    // If checkbox is checked, remove default from others
    if ($request->has('is_default')) {
        Address::where('user_id', auth()->id())
            ->update(['is_default' => false]);
    }

    Address::create([
        'user_id' => auth()->id(),
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'is_default' => $request->has('is_default'),
    ]);

    return redirect()->back()->with('success', 'Address added successfully.');
}


    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('profile', compact('addresses')); // adjust view as needed
    }
    

public function update(Request $request)
{
    $request->validate([
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|integer',
        'country' => 'required',
    ]);

    $address = Address::findOrFail($request->id);

    // Optional: Check if the address belongs to the authenticated user
    if ($address->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    $address->update([
        'address' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'country' => $request->country,
    ]);

    return redirect()->back()->with('success', 'Address updated successfully.');
}

// AddressController.php
public function setDefault($id)
{
    $user = auth()->user();

    // Make sure the address belongs to the user
    $address = Address::where('user_id', $user->id)->where('id', $id)->first();

    if (!$address) {
        return back()->with('error', 'Address not found.');
    }

    // Unset all defaults first
    Address::where('user_id', $user->id)->update(['is_default' => 0]);

    // Set this one as default
    $address->is_default = 1;
    $address->save();

    if (request()->ajax()) {
        return response()->json(['success' => true]);
    }

    return back()->with('success', 'Default address updated.');
}


}
