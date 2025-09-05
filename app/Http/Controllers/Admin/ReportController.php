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
        $totalSales = Sale::sum('total_amount');
        $totalOrders = Sale::count();
        $salesByBrand = DB::table('sale_items')
        ->join('products', 'sale_items.product_id', '=', 'products.id')
        ->join('brands', 'products.brand_id', '=', 'brands.id')
        ->select(
            'brands.name as brand_name',
            DB::raw('SUM(sale_items.quantity * sale_items.sale_price) as total_sales')
        )
        ->groupBy('brands.name')
        ->orderByDesc('total_sales')
        ->get();

        $brandsData = $salesByBrand->pluck('total_sales', 'brand_name')->toArray();
        //======End Output brand
        
        $hourlySales = DB::table('sale_items')
            ->selectRaw('HOUR(created_at) as hour, SUM(quantity * sale_price) as total_sales')
            ->whereDate('created_at', now()->toDateString())
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total_sales', 'hour') // key = hour, value = total_sales
            ->toArray();
            
        $hourlySalesArray = array_fill(0, 24, 0);
        foreach ($hourlySales as $hour => $total) {
            $hourlySalesArray[$hour] = (float) $total;
        }

        $sales = Sale::with(['items.product'])
        ->latest('date')
        ->take(8)
        ->get();

        $transactions = $sales->map(function ($sale) {
            // Combine all product names as a comma-separated string
            $products = $sale->items->pluck('product.name')->filter()->join(', ');

            return [
                'id'       => $sale->reference,
                'customer' => $sale->customer_id ?? 'Guest', // replace with actual customer name if you have relation
                'product'  => $products ?: 'N/A',
                'amount'   => $sale->total_amount,
                'status'   => $sale->status,
                'time'     => $sale->created_at->format('h:i A'),
            ];
        });
        // pp($transactions);

        return view('admin.reports.index', [
            'pageTitle' => __('messages.reports_list'),
            'heading' => __('messages.report_management_system'),
            'description' => __('messages.dashboard_welcome'),
            'topProducts' => $topProducts,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'hourlySales' => $hourlySalesArray,
            'brandsData' => $brandsData,
            'transactions' => $transactions,
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