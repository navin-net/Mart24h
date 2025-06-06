<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    public function index()
    {
        $pageTitle = __('messages.sales_list');
        $breadcrumbs = [
            ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
            ['label' => __('messages.sales'), 'url' => '', 'active' => true]
        ];
        $products = Products::select('id', 'name', 'sku')->get();
        return view('admin.sales.index', compact('pageTitle', 'breadcrumbs', 'products'));
    }

    public function getData(Request $request)
    {
        $query = Sale::withCount('items')->withSum('items', 'quantity');
        return DataTables::of($query)
            ->addColumn('action', function ($sale) {
                return '
                    <a href="#" class="show-sale action-btn" data-id="' . $sale->id . '" title="View">
                        <i class="bi bi-eye-fill text-primary"></i>
                    </a>
                    <a href="' . route('sales.edit', $sale->id) . '" class="action-btn" title="Edit">
                        <i class="bi bi-pencil-fill text-warning"></i>
                    </a>
                    <a href="#" class="delete-sale action-btn" data-id="' . $sale->id . '" title="Delete">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </a>';
            })
            ->editColumn('total_amount', function ($sale) {
                return ($sale->total_amount);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $products = Products::select('id', 'name', 'sku', 'stock_quantity', 'selling_price')->get();
        return view('admin.sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.sale_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request) {
            $sale = Sale::create([
                'customer_id' => null,
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'date' => $request->date,
            ]);

            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'sale_price' => $item['sale_price'],
                ]);

                Products::where('id', $item['product_id'])
                    ->decrement('stock_quantity', $item['quantity']);
            }
        });

        return response()->json([
            'message' => __('messages.sale_created_successfully'),
            'redirect' => route('sales.index')
        ], 201);
    }
    public function show($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        return response()->json(['sale' => $sale]);
    }

    public function edit($id)
    {
        $sale = Sale::with('items.product')->findOrFail($id);
        $products = Products::select('id', 'name', 'sku', 'stock_quantity', 'selling_price')->get();
        return view('admin.sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.sale_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request, $id) {
            $sale = Sale::findOrFail($id);

            // Restore stock for old items
            foreach ($sale->items as $item) {
                Products::where('id', $item->product_id)
                    ->increment('stock_quantity', $item->quantity);
            }

            // Update sale
            $sale->update([
                'total_amount' => $request->total_amount,
                'status' => $request->status,
                'date' => $request->date,
            ]);

            // Delete old items
            $sale->items()->delete();

            // Create new items
            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'sale_price' => $item['sale_price'],
                ]);

                // Update stock (allows negative stock)
                Products::where('id', $item['product_id'])
                    ->decrement('stock_quantity', $item['quantity']);
            }
        });

        return response()->json([
            'message' => __('messages.sale_updated_successfully'),
            'redirect' => route('sales.index')
        ]);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $sale = Sale::findOrFail($id);
            foreach ($sale->items as $item) {
                Products::where('id', $item->product_id)
                    ->increment('stock_quantity', $item->quantity);
            }
            $sale->items()->delete();
            $sale->delete();
        });

        return response()->json(['message' => __('messages.sale_deleted_successfully')]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $sale = Sale::find($id);
                if ($sale) {
                    foreach ($sale->items as $item) {
                        Products::where('id', $item->product_id)
                            ->increment('stock_quantity', $item->quantity);
                    }
                    $sale->items()->delete();
                    $sale->delete();
                }
            }
        });

        return response()->json(['message' => __('messages.selected_sales_deleted_successfully')]);
    }

    public function export(Request $request)
    {
        $ids = $request->query('ids') ? explode(',', $request->query('ids')) : null;
        return Excel::download(new SalesExport($ids), 'sales_' . now()->format('Y-m-d') . '.xlsx');
    }
}
