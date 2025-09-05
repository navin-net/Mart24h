<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Units;
use Yajra\DataTables\Facades\DataTables;


class UnitsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Units::select(['id', 'name', 'slug']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-primary btn-sm editUnits" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteUnits" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // pp($request->all());
        return view('admin.units.index', [
            'pageTitle' => __('messages.units_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                
                ['label' => __('messages.units'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:units,name',
            'slug' => 'nullable|max:55',
        ]);

        Units::create($request->only('name', 'slug'));

        return response()->json(['success' => 'units created successfully.']);
    }

    public function edit($id)
    {
        $Units = Units::findOrFail($id);
        return response()->json(['units' => $Units]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'slug' => 'nullable|max:55',
        ]);

        $units = Units::findOrFail($id);
        $units->update($request->only('name', 'slug'));

        return response()->json(['success' => 'Units updated successfully.']);
    }

    public function destroy($id)
    {
        $units = Units::findOrFail($id);
        $units->delete();

        return response()->json(['success' => 'Units deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        // Validate that IDs are provided
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:categories,id', // Validate each ID exists in the categories table
        ]);

        // Delete categories by IDs
        Units::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Selected units deleted successfully.']);
    }

}
