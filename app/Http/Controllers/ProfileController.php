<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Address;

class ProfileController extends Controller
{
public function update(Request $request)
{
    $request->validate([
        'dob' => 'nullable|date',
        'gender' => 'nullable|string',
        'city' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:20',
        'country' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/storage/products/profiles/' , 'public');
            // $imagePath = $image->store('products/profiles', 'public');

            $user->profile_image = $imagePath;
        }

        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->country = $request->country;
        $user->address = $request->address;
        $user->save();

        return response()->json(['message' => 'Profile updated successfully.']);
    } catch (\Exception $e) {
        \Log::error("Profile Update Error: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'message' => 'Error updating profile. Please check the logs for details.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function show(){
    $addresses = Address::where('user_id', Auth::id())->get();
        return view('profile', compact('addresses')); //
}

}
