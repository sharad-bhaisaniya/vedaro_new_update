<?php

namespace App\Http\Controllers;

use App\Models\GiftProduct;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index()
    {
        // Fetch all active gifts
        $gifts = GiftProduct::
            where(function ($query) {
                $query->whereNull('valid_from')
                      ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_to')
                      ->orWhere('valid_to', '>=', now());
            })
            ->get();

        return view('gift', compact('gifts'));
    }
}
