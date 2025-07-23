<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'review_title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            
            
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        Rating::create([
            'user_id' => $request->user_id, 
            'product_id' => $request->product_id, 
            'rating' => $request->rating,
            'review' => $request->review,
            'name' => $request->name,
            'review_title' => $request->review_title,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
    
     public function showReviews($productId)
        {
            $reviews = Rating::with('user')->where('product_id', $productId)->get();
        
            return view('product_details', compact('reviews'));
        }
    
        public function showProductDetails($productId)
        {
            $product = Product::findOrFail($productId);
        
            $reviews = Rating::with('user')->where('product_id', $productId)->get();
        
            $totalReviews = $reviews->count();
        
            $ratingsCount = [
                5 => $reviews->where('rating', 5)->count(),
                4 => $reviews->where('rating', 4)->count(),
                3 => $reviews->where('rating', 3)->count(),
                2 => $reviews->where('rating', 2)->count(),
                1 => $reviews->where('rating', 1)->count(),
            ];
        
            $averageRating = $totalReviews > 0
                ? $reviews->sum('rating') / $totalReviews
                : 0;
        
            return view('product_details', compact('product', 'reviews', 'totalReviews', 'ratingsCount', 'averageRating'));
        }

}
