<?php
namespace App\Http\Controllers;

use App\Models\LimitedEditionBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class LimitedEditionBannerController extends Controller
{
public function index()
{
    $banners = LimitedEditionBanner::latest()->get();
    $allProducts = Product::all();

    // Collect all assigned product IDs from all banners
    $assignedProductIds = collect($banners)->flatMap(function ($banner) {
        return explode(',', $banner->product_ids ?? '');
    })->filter()->unique()->toArray();

    // Only unassigned products go to the Featured Products section
    $unassignedProducts = $allProducts->whereNotIn('id', $assignedProductIds);

    return view('limited_banners.index', compact('banners', 'unassignedProducts', 'allProducts'));
}

public function assignProduct(Request $request, $id): JsonResponse
{
    $banner = LimitedEditionBanner::findOrFail($id);
    $productId = $request->input('product_id');

    if (!$productId) {
        return response()->json(['success' => false, 'message' => 'No product ID provided.']);
    }

    $productIds = $banner->product_ids ? explode(',', $banner->product_ids) : [];

    if (!in_array($productId, $productIds)) {
        $productIds[] = $productId;
    }

    $banner->product_ids = implode(',', $productIds);
    $banner->save();

    return response()->json(['success' => true, 'message' => 'Product assigned.']);
}

public function removeProduct(Request $request, $id): JsonResponse
{
    $banner = LimitedEditionBanner::findOrFail($id);
    $productId = $request->input('product_id');

    if (!$productId) {
        return response()->json(['success' => false, 'message' => 'No product ID provided.']);
    }

    $productIds = $banner->product_ids ? explode(',', $banner->product_ids) : [];

    // Remove product ID
    $productIds = array_filter($productIds, function ($id) use ($productId) {
        return $id != $productId;
    });

    $banner->product_ids = implode(',', $productIds);
    $banner->save();

    return response()->json(['success' => true, 'message' => 'Product removed from banner.']);
}


    public function create()
    {
           $products = Product::all(); 
        return view('limited_banners.create', compact('products'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');

        LimitedEditionBanner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->route('limited-banners.index')->with('success', 'Banner Created!');
    }

    public function edit($id)
    {
        $banner = LimitedEditionBanner::findOrFail($id);
        return view('limited_banners.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = LimitedEditionBanner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image) {
                Storage::delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $banner->update($data);

        return redirect()->route('limited-banners.index')->with('success', 'Banner Updated!');
    }


    
    public function show($id)
    {
        $banner = LimitedEditionBanner::findOrFail($id);
        return view('limited_banners.show', compact('banner'));
    }

    public function destroy($id)
    {
        $banner = LimitedEditionBanner::findOrFail($id);
        if ($banner->image) {
            Storage::delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('limited-banners.index')->with('success', 'Banner Deleted!');
    }
}
