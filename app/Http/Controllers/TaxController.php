<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\TaxGroup;
use Illuminate\Http\Request;

class TaxController extends Controller
{
 
    public function index()
{
    $taxes = Tax::orderBy('name')->get();
    $tax_groups = TaxGroup::all(); // The variable name is $tax_groups, not $tax_groups
    return view('admin.invoices.tax.index', compact('taxes', 'tax_groups'));
}

    // Show form to create tax
    public function create()
    {
        return view('admin.invoices.tax.create');
    }

    // Store new tax
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tax_group' => 'nullable|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        // $validated['is_active'] = $request->has('is_active') ? true : false;

        Tax::create($validated);

        return redirect()->route('taxes.index')->with('success', 'Tax created successfully!');
    }


       public function edit(Tax $tax)
    {
        return view('admin.invoices.tax.edit', compact('tax'));
    }

    public function update(Request $request, Tax $tax)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tax_group' => 'nullable|string|max:255',
            'rate' => 'required|numeric|min:0',
        ]);

        $tax->update($validated);

        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully!');
    }

    public function destroy(Tax $tax)
    {
        $tax->delete();

        return redirect()->route('taxes.index')->with('success', 'Tax deleted successfully!');
    }
}
