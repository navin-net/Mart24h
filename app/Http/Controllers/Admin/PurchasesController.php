<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PurchasesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('purchases')
                ->select(
                    'purchases.id',
                    'purchases.total_amount',
                    'purchases.date',
                    DB::raw('COUNT(purchase_items.id) as item_count'),
                    DB::raw('SUM(purchase_items.quantity) as total_quantity')
                )
                ->leftJoin('purchase_items', 'purchases.id', '=', 'purchase_items.purchase_id')
                ->groupBy('purchases.id', 'purchases.total_amount', 'purchases.date');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('admin.purchases.partials.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $products = Products::select('id', 'name', 'code')->get();

        return view('admin.purchases.index', [
            'pageTitle' => __('messages.purchases_list'),
            'heading' => __('messages.purchases_list'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.purchases'), 'url' => '', 'active' => true],
            ],
            'products' => $products
        ]);
    }

    public function create()
    {
        $products = Products::select('id', 'name', 'code', 'stock_quantity', 'cost_price')->get();

        return view('admin.purchases.create', [
            'products' => $products,
            'pageTitle' => __('messages.add_purchase'),
            'heading' => __('messages.add_purchase'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.purchases'), 'url' => route('purchases.index'), 'active' => false],
                ['label' => __('messages.create'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Verify total_amount and cost_price
        $calculatedTotal = 0;
        $productIds = array_column($request->items, 'product_id');
        $products = Products::whereIn('id', $productIds)->pluck('cost_price', 'id');

        foreach ($request->items as $index => $item) {
            if (!isset($products[$item['product_id']]) || abs($products[$item['product_id']] - $item['cost_price']) > 0.01) {
                $validator->errors()->add("items.$index.cost_price", 'Invalid cost price for the selected product.');
            }
            $calculatedTotal += $item['quantity'] * $item['cost_price'];
        }

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (abs($calculatedTotal - $request->total_amount) > 0.01) {
            return response()->json(['errors' => ['total_amount' => ['The total amount does not match the sum of items.']]], 422);
        }

        try {
            DB::transaction(function () use ($request) {
                $purchase = Purchase::create([
                    'supplier_id' => null,
                    'total_amount' => $request->total_amount,
                    'date' => $request->date,
                    'status' => $request->status,
                ]);

                foreach ($request->items as $item) {
                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'cost_price' => $item['cost_price'],
                    ]);

                    $product = Products::find($item['product_id']);
                    if ($product) {
                        $product->increment('stock_quantity', $item['quantity']);
                    } else {
                        throw new \Exception("Product with ID {$item['product_id']} not found.");
                    }
                }
            });

            session()->flash('success', __('messages.purchase_created'));

            Log::info('Purchase created', ['total_amount' => $request->total_amount, 'items' => $request->items]);

            return response()->json([
                'message' => __('messages.purchase_created_successfully'),
                'redirect' => route('purchases.index')
            ], 201);
        } catch (\Exception $e) {
            Log::error('Purchase creation failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while creating the purchase: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);
        return response()->json(['purchase' => $purchase->toArray()]); // Explicitly convert to array
    }

    public function edit($id)
    {
        $purchase = Purchase::with('items.product')->findOrFail($id);
        $products = Products::select('id', 'name', 'code')->get();

        return response()->json([
            'purchase' => $purchase,
            'products' => $products
        ]);
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request, $purchase) {
            foreach ($purchase->items as $oldItem) {
                Products::where('id', $oldItem->product_id)
                    ->decrement('stock_quantity', $oldItem->quantity);
            }

            $purchase->items()->delete();

            $purchase->update([
                'supplier_id' => null,
                'total_amount' => $request->total_amount,
                'date' => $request->date,
            ]);

            foreach ($request->items as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'cost_price' => $item['cost_price'],
                ]);

                Products::where('id', $item['product_id'])
                    ->increment('stock_quantity', $item['quantity']);
            }
        });

        session()->flash('success', __('messages.purchase_updated'));

        return response()->json([
            'message' => __('messages.purchase_updated'),
            'redirect' => route('purchases.index')
        ], 200);
    }

    public function destroy($id)
    {
        $purchase = Purchase::with('items')->findOrFail($id);

        DB::transaction(function () use ($purchase) {
            // Decrement stock quantities before deleting items
            foreach ($purchase->items as $item) {
                Products::where('id', $item->product_id)
                    ->decrement('stock_quantity', $item->quantity);
            }

            // Delete purchase items
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            // Delete the purchase
            $purchase->delete();
        });

        session()->flash('success', __('messages.purchase_deleted_successfully'));

        return response()->json(['message' => __('messages.purchase_deleted_successfully')], 200);
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        DB::transaction(function () use ($ids) {
            $purchases = Purchase::whereIn('id', $ids)->get();

            foreach ($purchases as $purchase) {
                foreach ($purchase->items as $item) {
                    Products::where('id', $item->product_id)
                        ->decrement('stock_quantity', $item->quantity);
                }
                $purchase->delete();
            }
        });

        return response()->json(['message' => __('messages.selected_purchases_deleted_successfully')], 200);
    }

    public function export(Request $request)
    {
        $ids = $request->input('ids', []);

        $purchases = Purchase::whereIn('id', $ids)
            ->with('items.product')
            ->get();

        return response()->json($purchases);
    }
}
