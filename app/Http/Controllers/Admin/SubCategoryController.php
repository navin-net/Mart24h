<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCategory::select([
                'sub_categories.id',
                'sub_categories.name as sub_category_name',
                'sub_categories.category_id',
                'categories.name as category_name'
            ])
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="actionDropdown' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionDropdown' . $row->id . '">
                                <li><a class="dropdown-item editCategory" href="javascript:void(0);" data-id="' . $row->id . '">Edit</a></li>
                                <li><a class="dropdown-item deleteCategory" href="javascript:void(0);" data-id="' . $row->id . '">Delete</a></li>
                            </ul>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.sub_category.index', [
            'pageTitle' => __('messages.sub_category_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.settings'), 'url' => '#', 'active' => false],
                ['label' => __('messages.sub_category'), 'url' => '', 'active' => true],
            ]
        ]);
    }
}
