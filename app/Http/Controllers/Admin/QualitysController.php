<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qualitys;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class QualitysController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Qualitys::select(['id', 'name', 'description']);
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-primary btn-sm editQuality" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm deleteQuality" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.qualitys.index', [
            'pageTitle' => __('messages.qualitys_list'),
            'heading' => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                
                ['label' => __('messages.qualitys'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:qualitys,name',
            'description' => 'nullable|max:55',
        ]);

        Qualitys::create($request->only('name', 'description'));

        return response()->json(['success' => 'Qualitys created successfully.']);
    }

    public function edit($id)
    {
        $qualitys = Qualitys::findOrFail($id);
        return response()->json(['qualitys' => $qualitys]);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required|max:50|unique:qualitys,name,' . $id,
        //     'description' => 'nullable|max:55',
        // ]);

        $qualitys = Qualitys::findOrFail($id);
        $qualitys->update($request->only('name', 'description'));

        return response()->json(['success' => 'Qualitys updated successfully.']);
    }

    public function destroy($id)
    {
        $qualitys = Qualitys::findOrFail($id);
        $qualitys->delete();

        return response()->json(['success' => 'Qualitys deleted successfully.']);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:qualitys,id',
        ]);

        Qualitys::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => 'Selected qualitys deleted successfully.']);
    }
}
