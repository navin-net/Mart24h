<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
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
                    <div class="d-flex gap-2">
                        <button type="button" 
                                class="btn btn-sm btn-outline-primary editCategory" 
                                data-id="' . $row->id . '" 
                                title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger deleteCategory" 
                                data-id="' . $row->id . '" 
                                title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
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

    public function sub_category(Request $request)
    {
        $categories = Categories::all();

        if ($request->ajax()) {
            $data = SubCategory::select([
                    'sub_categories.id',
                    'sub_categories.name as sub_category_name',
                    'categories.name as category_name',
                ])
                ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-2">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-primary editSubCategory" 
                                    data-id="' . $row->id . '" 
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger deleteSubCategory" 
                                    data-id="' . $row->id . '" 
                                    title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // return view('admin.sub_category.index', compact('categories'));
        return view('admin.sub_category.index', [
            'categories'  => $categories,
            'pageTitle'   => __('messages.categories_list'),
            'heading'     => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.categories'), 'url' => '', 'active' => true],
            ],
        ]);

    }


    public function store_sub_category(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        SubCategory::create($request->only('name', 'category_id'));

        return response()->json(['success' => 'Subcategory created successfully.']);
    }

    public function edit_sub_category($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        return response()->json(['subCategory' => $subCategory]);
    }

    public function update_sub_category(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);

        $subCategory = SubCategory::findOrFail($id);
        $subCategory->update($request->only('name', 'category_id'));

        return response()->json(['success' => 'Subcategory updated successfully.']);
    }

    public function delete_sub_category($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();

        return response()->json(['success' => 'Subcategory deleted successfully.']);
    }

    public function bulkDeleteSubCategories(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:sub_categories,id',
        ]);

        SubCategory::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Selected subcategories deleted.']);
    }

}
