<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class BillerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('companies')
                ->leftJoin('groups', 'companies.group_id', '=', 'groups.id')
                ->leftJoin('warehouses', 'companies.warehouse_id', '=', 'warehouses.id')
                ->select(
                    'companies.id',
                    'companies.name',
                    'companies.email',
                    'companies.city',
                    'companies.number_of_houses',
                    'companies.street',
                    'companies.address',
                    'companies.phone',
                    'groups.name as group_name',
                    'warehouses.name as warehouse_name'
                )->where('companies.group_id', 2);

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return ' <button class="btn btn-primary btn-sm editCompany" data-id="'.$row->id.'">Edit</button> <button class="btn btn-danger btn-sm deleteCompany" data-id="'.$row->id.'">Delete</button> ';
                })
                ->filterColumn('group_name', function ($query, $keyword) {
                    $query->where('groups.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('warehouse_name', function ($query, $keyword) {
                    $query->where('warehouses.name', 'like', "%{$keyword}%");
                })
                ->orderColumn('group_name', 'groups.name $1')
                ->orderColumn('warehouse_name', 'warehouses.name $1')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.billers.index', [
            'pageTitle'   => __('messages.billers_list'),
            'heading'     => __('messages.stock_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.biller'), 'url'  => false],
            ]
        ]);
    }

    public function create()
    {
        return view('admin.billers.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new biller
    }

    public function edit($id)
    {
        // Logic to show form for editing an existing biller
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing biller
    }

    public function destroy($id)
    {
        // Logic to delete a biller
    }
}
