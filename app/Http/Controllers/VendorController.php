<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(20);
        return view('admin.invoices.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('admin.invoices.vendor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'display_name' => 'required|unique:vendors|max:255',
            'company_name' => 'nullable|max:255',
            'salutation' => 'nullable|in:Mr.,Mrs.,Ms.,Dr.',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'email' => 'nullable|email|unique:vendors,email',
            'phone' => 'nullable|max:20',
            'mobile' => 'nullable|max:20',
            'gst_no' => 'nullable|max:50',
            'pan_no' => 'nullable|max:20',
            'hsn_code' => 'nullable|max:20',
            'address' => 'nullable|max:255',
            'billing_address' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'account_number' => 'nullable|max:50',
            'bank_name' => 'nullable|max:100',
            'ifsc_code' => 'nullable|max:20',
            'branch_name' => 'nullable|max:100',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        Vendor::create($validated);

        return redirect()->route('vendor.index')
            ->with('success', 'Vendor created successfully.');
    }

        // Show the edit form
public function edit(Vendor $vendor)
{
    return view('admin.invoices.vendor.edit', compact('vendor'));
}

// Update vendor data
public function update(Request $request, Vendor $vendor)
{
    $validated = $request->validate([
        'display_name' => 'required|max:255|unique:vendors,display_name,' . $vendor->id,
        'company_name' => 'nullable|max:255',
        'salutation' => 'nullable|in:Mr.,Mrs.,Ms.,Dr.',
        'first_name' => 'required|max:100',
        'last_name' => 'required|max:100',
        'email' => 'nullable|email|unique:vendors,email,' . $vendor->id,
        'phone' => 'nullable|max:20',
        'mobile' => 'nullable|max:20',
        'gst_no' => 'nullable|max:50',
        'pan_no' => 'nullable|max:20',
        'hsn_code' => 'nullable|max:20',
        'address' => 'nullable|max:255',
        'billing_address' => 'nullable|string',
        'shipping_address' => 'nullable|string',
        'account_number' => 'nullable|max:50',
        'bank_name' => 'nullable|max:100',
        'ifsc_code' => 'nullable|max:20',
        'branch_name' => 'nullable|max:100',
        'status' => 'required|in:active,inactive',
        'notes' => 'nullable|string'
    ]);

    $vendor->update($validated);

    return redirect()->route('vendor.index')
        ->with('success', 'Vendor updated successfully.');
}

// Optional: destroy method
public function destroy(Vendor $vendor)
{
    $vendor->delete();
    return redirect()->route('vendor.index')->with('success', 'Vendor deleted successfully.');
}




        // for filter the vendor by searchin
   public function search(Request $request)
{
    $search = $request->input('search');

    $vendors = Vendor::query()
        ->where('display_name', 'like', "%$search%")
        ->orWhere('company_name', 'like', "%$search%")
        ->orWhere('gst_no', 'like', "%$search%")
        ->orWhere('email', 'like', "%$search%")
        ->orWhere('phone', 'like', "%$search%")
        ->paginate(10); // 👈 Better than limit(10), supports pagination

    return view('admin.invoices.vendor.index', compact('vendors', 'search'));
}

}
