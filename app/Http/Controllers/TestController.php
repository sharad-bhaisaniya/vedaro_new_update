<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function test(Request $request)
    {
        if ($request->isMethod('post')) {
            // Handle form submission (POST request)
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:tests,email',
            ]);

            // Save data to the database
            Test::create($validated);

            // Redirect with a success message
            return redirect()->route('test')->with('success', 'Data submitted successfully!');
        }

        // Handle GET request (show form)
        return view('test');
    }
}