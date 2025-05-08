<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Routing\Controller;


class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Categories::select(['id', 'name', 'slug']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-primary btn-sm editCategory" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteCategory" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.categories.index', [
            'pageTitle' => __('messages.categories_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.settings'), 'url' => '#', 'active' => false],
                ['label' => __('messages.categories'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'nullable|max:55',
        ]);

        Categories::create($request->only('name', 'slug'));

        return response()->json(['success' => 'Category created successfully.']);
    }

    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return response()->json(['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'nullable|max:55',
        ]);

        $category = Categories::findOrFail($id);
        $category->update($request->only('name', 'slug'));

        return response()->json(['success' => 'Category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();

        return response()->json(['success' => 'Category deleted successfully.']);
    }
    public function bulkDelete(Request $request)
    {
        // Validate that IDs are provided
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:categories,id', // Validate each ID exists in the categories table
        ]);

        // Delete categories by IDs
        Categories::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Selected categories deleted successfully.']);
    }

}
