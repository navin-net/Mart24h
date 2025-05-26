<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::latest()->get();
            return datatables()->of($data)
                ->addColumn('image', fn($row) => $row->image ? '<img src="' . asset('storage/' . $row->image) . '" width="80"/>' : 'No image')
                ->addColumn('action', fn($row) => view('admin.settings.banner.partials.actions', compact('row'))->render())
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        $pageTitle = 'Banners';
        $breadcrumbs = [['label' => 'Dashboard', 'url' => route('dashboard'), 'active' => false], ['label' => 'Banners', 'url' => '', 'active' => true]];
        return view('admin.settings.banner.index', compact('pageTitle', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('title', 'description');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($data);
        return response()->json(['message' => 'Banner created successfully.']);
    }

    public function edit(Banner $banner)
    {
        return response()->json(['banner' => $banner]);
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('title', 'description');
        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);
        return response()->json(['message' => 'Banner updated successfully.']);
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return response()->json(['message' => 'Banner deleted successfully.']);
    }
}
