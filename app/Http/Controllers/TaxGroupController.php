<?php

namespace App\Http\Controllers;

use App\Models\TaxGroup;
use Illuminate\Http\Request;

class TaxGroupController extends Controller
{
  

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
            'taxes' => 'required|array',
        ]);

        $group = TaxGroup::create([
            'name' => $validated['group_name'],
        ]);

        $group->taxes()->attach($validated['taxes']);

        return redirect()->back()->with('success', 'Tax group created successfully!');
    }
}
