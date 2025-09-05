<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouses;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Warehouses::select(['id', 'name', 'location', 'note']);

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('admin.warehouse.partials.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.warehouse.index', [
            'pageTitle' => __('messages.warehouse_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                
                ['label' => __('messages.warehouse'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    /**
     * Store a newly created warehouse.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'note'     => 'nullable|string|max:255',
        ]);

        $warehouse = Warehouses::create($validated);

        return response()->json([
            'success'   => true,
            'message'   => 'Warehouse added successfully',
            'warehouse' => $warehouse
        ]);
    }

    /**
     * Show the warehouse for editing (AJAX).
     */
    public function edit($id)
    {
        $warehouse = Warehouses::findOrFail($id);
        return response()->json(['warehouse' => $warehouse]);
    }

    /**
     * Update the specified warehouse.
     */
    public function update(Request $request, $id)
    {
        $warehouse = Warehouses::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'note'     => 'nullable|string|max:255',
        ]);

        $warehouse->update($validated);

        return response()->json([
            'success'   => true,
            'message'   => 'Warehouse updated successfully',
            'warehouse' => $warehouse
        ]);
    }

    /**
     * Remove the specified warehouse.
     */
    public function destroy($id)
    {
        $warehouse = Warehouses::findOrFail($id);
        $warehouse->delete();

        return response()->json([
            'success' => true,
            'message' => 'Warehouse deleted successfully'
        ]);
    }
}
