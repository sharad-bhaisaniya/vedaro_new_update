<?php

namespace App\Http\Controllers;

// ... rest of your code

use App\Models\UserInquiry; // Import the UserInquiry model
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the user inquiries.
     */
    public function index()
    {
        // Fetch all inquiries from the database, ordered by creation date
        $inquiries = UserInquiry::orderBy('created_at', 'desc')->get();

        // Pass the inquiries to the view
        return view('admin.user_inquiry', compact('inquiries'));
    }

    /**
     * Show the form for creating a new inquiry (if you have a contact form)
     */


    /**
     * Store a newly created inquiry in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
             'phone' => 'required|string|min:10|max:15', // ✅ Fixed line
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        UserInquiry::create($validatedData);

        return redirect()->back()->with('success', 'Your inquiry has been sent successfully!');
    }
}