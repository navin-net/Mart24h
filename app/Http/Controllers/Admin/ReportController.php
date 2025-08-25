<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;



class ReportController extends Controller
{
    public function index(Request $request)
    {

        $topProducts = DB::table('products')
            ->select('id', 'name', 'cost_price as revenue', 'selling_price as sales')
            ->get();
        // pp($products);
        
        
        return view('admin.reports.index', [
            'pageTitle' => __('messages.reports_list'),
            'heading' => __('messages.report_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'topProducts' => $topProducts,
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.reports'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function getReport(Request $request)
    {
        $filter = $request->get('filter', 'daily'); // daily, monthly, yearly

        $query = Sale::with(['items.product'])
            ->withSum('items', 'quantity')   // total quantity sold
            ->orderBy('date', 'desc');

        // Date filtering
        if ($filter === 'daily') {
            $query->whereDate('date', now()->toDateString());
        } elseif ($filter === 'monthly') {
            $query->whereMonth('date', now()->month)
                ->whereYear('date', now()->year);
        } elseif ($filter === 'yearly') {
            $query->whereYear('date', now()->year);
        }

        return DataTables::of($query)
            ->addColumn('products', function ($sale) {
                return $sale->items->map(function ($item) {
                    return $item->product->name . ' (x' . $item->quantity . ')';
                })->implode('<br>');
            })
            ->editColumn('total_amount', function ($sale) {
                return number_format($sale->total_amount, 2);
            })
            ->rawColumns(['products'])
            ->make(true);
    }


    public function ReportDaily()
    {
        return view('admin.reports.report_daily', [
            'pageTitle' => __('messages.report_daily'),
            'heading' => __('messages.report_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '/admin/dashboard', 'active' => false],
                ['label' => __('messages.reports'), 'url' => '', 'active' => true],
            ]
        ]);
    }


}