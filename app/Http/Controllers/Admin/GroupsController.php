<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groups;
use Yajra\DataTables\Facades\DataTables;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    if ($request->ajax()) {
        $data = Groups::select(['id', 'name']);
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '
                    <div class="d-flex gap-2">
                        <button type="button" 
                                class="btn btn-sm btn-outline-primary editGroup" 
                                data-id="' . $row->id . '" 
                                title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger deleteGroup" 
                                data-id="' . $row->id . '" 
                                title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);}
        return view('admin.groups.index', [
            'pageTitle' => __('messages.groups_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                
                ['label' => __('messages.groups'), 'url' => '', 'active' => true],
            ]
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
        ]);

        $group = Groups::create($validated);

        return response()->json([
            'success'   => true,
            'message'   => 'Group added successfully',
            'group' => $group
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Groups::findOrFail($id);
        return response()->json(['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group = Groups::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Group updated successfully',
            'group'   => $group
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = groups::findOrFail($id);
        $group->delete();

        return response()->json([
            'success' => true,
            'message' => 'group deleted successfully'
        ]);
    }


    public function bulkDelete(Request $request)
    {
        // Validate that IDs are provided
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:groups,id', // Validate each ID exists in the groups table
        ]);

        // Delete groups by IDs
        Groups::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Selected groups deleted successfully.']);
    }



}
