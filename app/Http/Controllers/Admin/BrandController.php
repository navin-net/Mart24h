<?php

// app\Http\Controllers\Admin\BrandController.php
namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BrandExport;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    // Display the list of brands with DataTables
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::select(['id', 'code', 'name', 'image', 'slug', 'description']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('admin.brands.partials.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.brands.index', [
            'pageTitle' => __('messages.brands_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.settings'), 'url' => '#', 'active' => false],
                ['label' => __('messages.brands'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    // Store a new brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'code' => 'nullable|max:20',
            'image' => 'nullable|image|max:1024',
            'slug' => 'nullable|max:55',
            'description' => 'nullable|max:255',
        ]);

        $data = $request->except('image');

        if ($image = $request->file('image')) {
            $destinationPath = 'upload/image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $data['image'] = $profileImage;
        }

        Brand::create($data);

        return response()->json(['success' => __('messages.brand_added_successfully')]);
    }

    // Fetch a brand for editing
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return response()->json($brand);
    }

    // Update a brand
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'code' => 'nullable|max:20',
            'image' => 'nullable|image|max:1024',
            'slug' => 'nullable|max:55',
            'description' => 'nullable|max:255',
        ]);

        $brand = Brand::findOrFail($id);
        $data = $request->except('image');

        if ($image = $request->file('image')) {
            $destinationPath = 'upload/image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            if ($brand->image && file_exists(public_path($destinationPath . $brand->image))) {
                unlink(public_path($destinationPath . $brand->image));
            }

            $image->move($destinationPath, $profileImage);
            $data['image'] = $profileImage;
        }

        $brand->update($data);

        return response()->json(['success' => __('messages.brand_updated_successfully')]);
    }

    // Delete a brand
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image && file_exists(public_path('upload/image/' . $brand->image))) {
            unlink(public_path('upload/image/' . $brand->image));
        }

        $brand->delete();

        return response()->json(['success' => __('messages.brand_deleted_successfully')]);
    }

    // Bulk delete brands
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        $brands = Brand::whereIn('id', $ids)->get();

        foreach ($brands as $brand) {
            if ($brand->image && file_exists(public_path('upload/image/' . $brand->image))) {
                unlink(public_path('upload/image/' . $brand->image));
            }
            $brand->delete();
        }

        return response()->json(['success' => __('messages.selected_brands_deleted_successfully')]);
    }

    // Export brands to Excel
    public function export(Request $request)
    {
        $selectedBrandIds = $request->input('ids');
        $brandIds = $selectedBrandIds ? explode(',', $selectedBrandIds) : [];

        return Excel::download(new BrandExport($brandIds), 'brands.xlsx');
    }
}
