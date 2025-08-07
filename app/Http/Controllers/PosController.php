<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use App\Models\Sale;
use App\Models\Brand;
use App\Models\Payment;
use App\Models\SaleItem;
use App\Events\CartUpdated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Products::with(['category', 'brand'])
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->selling_price,
                    'image' => $product->image ? asset($product->image) : asset('images/placeholder.jpg'),
                    'category' => $product->category->name ?? 'N/A',
                    'brand' => $product->brand->name ?? 'N/A',
                ];
            });

        $categories = Categories::all();
        $brands = Brand::all();

        // dd($products);
        return view('admin.pos', compact('products', 'categories', 'brands'));
    }

    public function search(Request $request)
    {
        $query = $request->query('query', '');
        $category = $request->query('category', 'all');
        $sort = $request->query('sort', 'name-asc');

        $productsQuery = Products::with(['category', 'brand'])
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($category !== 'all', function ($q) use ($category) {
                return $q->whereHas('category', fn($q) => $q->where('slug', $category));
            });

        [$sortField, $sortDirection] = $this->getSortParameters($sort);
        $productsQuery->orderBy($sortField, $sortDirection);

        $products = $productsQuery->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->selling_price,
                'image' => $product->image ? asset($product->image) : asset('images/placeholder.jpg'),
                'category' => $product->category->name ?? 'N/A',
                'brand' => $product->brand->name ?? 'N/A',
            ];
        });

        return view('admin.partials.product-list', compact('products'))->render();
    }

    public function filter(Request $request)
    {
        $query = $request->query('query', '');
        $category = $request->query('category', 'all');
        $sort = $request->query('sort', 'name-asc');

        $productsQuery = Products::with(['category', 'brand'])
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%")
                        ->orWhere('code', 'like', "%{$query}%"); // Added product code filtering
            })
            ->when($category !== 'all', function ($q) use ($category) {
                return $q->whereHas('category', fn($q) => $q->where('slug', $category));
            })
            ->when($request->has('brand') && $request->brand !== 'all', function ($q) use ($request) {
                return $q->whereHas('brand', fn($q) => $q->where('slug', $request->brand));
            });

        [$sortField, $sortDirection] = $this->getSortParameters($sort);
        $productsQuery->orderBy($sortField, $sortDirection);

        $products = $productsQuery->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code, // Include code in the response
                'price' => $product->selling_price,
                'image' => $product->image ? asset($product->image) : asset('images/placeholder.jpg'),
                'category' => $product->category->name ?? 'N/A',
                'brand' => $product->brand->name ?? 'N/A',
            ];
        });

        return view('admin.partials.product-list', compact('products'))->render();
    }




    private function getSortParameters($sort)
    {
        return match ($sort) {
            'name-asc' => ['name', 'asc'],
            'name-desc' => ['name', 'desc'],
            'price-asc' => ['selling_price', 'asc'],
            'price-desc' => ['selling_price', 'desc'],
            'created-asc' => ['created_at', 'asc'],
            'created-desc' => ['created_at', 'desc'],
            default => ['name', 'asc'],
        };
    }

public function processPayment(Request $request)
{
    $request->validate([
        'cart' => 'required|array',
        'cart.*.id' => 'required|exists:products,id',
        'cart.*.quantity' => 'required|integer|min:1',
        'payment_method' => 'required|in:cash,card,digital',
    ]);

    try {
        DB::beginTransaction();

        $cart = $request->cart;
        $paymentMethod = $request->payment_method;
        $subtotal = 0;

        foreach ($cart as $item) {
            $product = Products::findOrFail($item['id']);
            if ($product->stock_quantity < $item['quantity']) {
                throw new \Exception("Payment processing failed: Insufficient stock for {$product->name}");
            }
            $subtotal += $product->selling_price * $item['quantity'];
        }

        $tax = $subtotal * 0.08;
        $total = $subtotal + $tax;

        $sale = Sale::create([
            'customer_id' => null,
            'total_amount' => $total,
            'status' => 'completed',
            'payment_method' => $paymentMethod,
            'date' => now(),
            'reference' => 'SALE-' . time(),
        ]);

        foreach ($cart as $item) {
            $product = Products::findOrFail($item['id']);
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'sale_price' => $product->selling_price,
            ]);
            $product->decrement('stock_quantity', $item['quantity']);
        }

        Payment::create([
            'sale_id' => $sale->id,
            'method' => $paymentMethod,
            'amount' => $total,
            'paid_at' => now(),
            'reference' => 'POS-' . $sale->id . '-' . time(),
        ]);

        $receipt = view('admin.partials.receipt', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'sale' => $sale,
            'payment_method' => $paymentMethod,
        ])->render();

        DB::commit();

        // Broadcast empty cart after successful payment
        broadcast(new CartUpdated([], 0, 0, 0))->toOthers();

        return response()->json([
            'success' => true,
            'receipt' => $receipt,
            'transaction_id' => $sale->id,
            'total' => $total,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}
    public function customerDisplay()
    {
        return view('admin.customer-display');
    }
    public function broadcastCart(Request $request)
    {
        broadcast(new CartUpdated(
            $request->input('cart', []),
            $request->input('subtotal', 0),
            $request->input('tax', 0),
            $request->input('total', 0)
        ))->toOthers();

        return response()->json(['status' => 'Broadcasted']);
    }

}