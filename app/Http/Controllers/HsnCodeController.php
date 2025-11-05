<?php

namespace App\Http\Controllers;

use App\Models\HsnCode;
use Illuminate\Http\Request;

class HsnCodeController extends Controller
{
    public function index()
    {
        $hsnCodes = HsnCode::latest()->paginate(10);
        return view('hsn.index', compact('hsnCodes'));
    }

    public function create()
    {
        return view('hsn.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:hsn_codes',
            'description' => 'nullable|string',
        ]);

        HsnCode::create($validated);
        return redirect()->route('hsn.index')->with('success', 'HSN Code created successfully.');
    }

    public function edit(HsnCode $hsn)
    {
        return view('hsn.edit', compact('hsn'));
    }

    public function update(Request $request, HsnCode $hsn)
    {
        $validated = $request->validate([
            'code' => 'required|unique:hsn_codes,code,' . $hsn->id,
            'description' => 'nullable|string',
        ]);

        $hsn->update($validated);
        return redirect()->route('hsn.index')->with('success', 'HSN Code updated successfully.');
    }

    public function destroy(HsnCode $hsn)
    {
        $hsn->delete();
        return redirect()->route('hsn.index')->with('success', 'HSN Code deleted successfully.');
    }
}
