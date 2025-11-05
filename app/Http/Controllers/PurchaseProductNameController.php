<?php

namespace App\Http\Controllers;

use App\Models\PurchaseProductName;
use Illuminate\Http\Request;

class PurchaseProductNameController extends Controller
{
    public function index()
    {
        $products = PurchaseProductName::orderBy('id', 'desc')->get();
        return view('purchase_product_names.index', compact('products'));
    }

    public function create()
    {
        return view('purchase_product_names.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:purchase_product_names,name|max:255',
        ]);

        PurchaseProductName::create(['name' => $request->name]);

        return redirect()->route('purchase-product-names.index')->with('success', 'Product name added successfully!');
    }

    public function edit(PurchaseProductName $purchaseProductName)
    {
        return view('purchase_product_names.edit', compact('purchaseProductName'));
    }

    public function update(Request $request, PurchaseProductName $purchaseProductName)
    {
        $request->validate([
            'name' => 'required|max:255|unique:purchase_product_names,name,' . $purchaseProductName->id,
        ]);

        $purchaseProductName->update(['name' => $request->name]);

        return redirect()->route('purchase-product-names.index')->with('success', 'Product name updated successfully!');
    }

    public function destroy(PurchaseProductName $purchaseProductName)
    {
        $purchaseProductName->delete();
        return redirect()->back()->with('success', 'Product name deleted!');
    }
}
