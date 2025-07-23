<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Banner;
    use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // Show create form
    public function create()
    {
        return view('create_banner');
    }

    // Store banner
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required|in:image,video',
            'file' => 'required|file|max:20480',
        ]);

        $path = $request->file('file')->store('banners', 'public');

        // If setting active, make all others inactive first
        if ($request->has('is_active')) {
            Banner::query()->update(['is_active' => false]);
        }

        Banner::create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $path,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    // Show all banners
    public function index()
    {
        $banners = Banner::all();
        return view('all_banners', compact('banners'));
    }

    // Activate selected banner
    public function activate($id)
    {
        Banner::query()->update(['is_active' => false]); // deactivate all
        Banner::where('id', $id)->update(['is_active' => true]); // activate selected
        return back()->with('success', 'Banner activated.');
    }
    

public function destroy($id)
{
    $banner = Banner::findOrFail($id);

    // Delete file from storage
    if ($banner->file_path && Storage::disk('public')->exists('products/' . $banner->file_path)) {
        Storage::disk('public')->delete('products/' . $banner->file_path);
    }

    // Delete the banner record
    $banner->delete();

    return redirect()->back()->with('success', 'Banner deleted successfully.');
}
}
