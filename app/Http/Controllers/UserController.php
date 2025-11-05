<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //
    function getUser(){
        return "Mahakal";
    }

    function aboutUser(){
        return "aboutUser Mahakal";
    }

    function getUserName($name){
        return "hello this is " .$name;
    }
    
    // In UserController.php


        // Update User 
  
public function updateProfile(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:Male,Female,Other',
        'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Handle profile image
    if ($request->hasFile('profile_image')) {
        // Delete old image if exists
        if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
            Storage::delete('public/profile_images/' . $user->profile_image);
        }

        // Store new image
        $image = $request->file('profile_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/profile_images', $imageName);

        $data['profile_image'] = $imageName;
    }

    $user->update($data);

    return back()->with('success', 'Profile updated successfully!');
}

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'          => 'required',
            'new_password'              => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address'  => 'nullable|string|max:255',
            'city'     => 'nullable|string|max:100',
            'state'    => 'nullable|string|max:100',
            'pincode'  => 'nullable|max:20',
            'country'  => 'nullable|string|max:100',
        ]);

        $user->update($request->only(['address', 'city', 'state', 'pincode', 'country']));

        return back()->with('success', 'Address updated successfully.');
    }
    
    public function check($pincode)
{
    try {
        // Call Shiprocket open API properly with query string
        $url = 'https://apiv2.shiprocket.in/v1/external/open/postcode/details?postcode=' . $pincode;

        $response = \Illuminate\Support\Facades\Http::get($url);

        if ($response->failed()) {
            return response()->json([
                'available' => false,
                'message' => 'Error fetching data from Shiprocket API.',
            ]);
        }

        $data = $response->json();

        // Check response structure
        if (
            isset($data['delivery_postcode_details']) &&
            isset($data['delivery_postcode_details']['postcode']) &&
            isset($data['delivery_postcode_details']['city'])
        ) {
            return response()->json([
                'available' => true,
                'message' => 'Delivery available for this pincode.',
                'details' => $data['delivery_postcode_details'],
            ]);
        }

        return response()->json([
            'available' => false,
            'message' => 'Delivery not available for this pincode.',
            'details' => $data,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'available' => false,
            'message' => 'Server error: ' . $e->getMessage(),
        ]);
    }
}

}
