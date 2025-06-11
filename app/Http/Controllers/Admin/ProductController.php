<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('products')
                ->select(
                    'products.id',
                    'products.image',
                    'products.name',
                    'products.sku',
                    'products.stock_quantity',
                    'products.cost_price',
                    'products.selling_price',
                    'brands.name as brand_name',
                    'categories.name as category_name',
                    'sub_categories.name as subcategory_name',
                    'qualitys.name as quality_name'
                )
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('sub_categories', 'products.subcategory_id', '=', 'sub_categories.id')
                ->leftJoin('qualitys', 'products.quality_id', '=', 'qualitys.id');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return view('admin.products.partials.actions', compact('row'))->render();
                })
                ->filterColumn('brand_name', function ($query, $keyword) {
                    $query->where('brands.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->where('categories.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('subcategory_name', function ($query, $keyword) {
                    $query->where('sub_categories.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('quality_name', function ($query, $keyword) {
                    $query->where('qualitys.name', 'like', "%{$keyword}%");
                })
                ->orderColumn('brand_name', 'brands.name $1')
                ->orderColumn('category_name', 'categories.name $1')
                ->orderColumn('subcategory_name', 'sub_categories.name $1')
                ->orderColumn('quality_name', 'qualitys.name $1')
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.products.index', [
            'pageTitle' => __('messages.products_list'),
            'heading' => __('messages.products_list'),
            'description' => __('messages.dashboard_welcome'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.products'), 'url' => '', 'active' => true],
            ]
        ]);
    }
    public function getData()
    {
        $data = DB::table('products')
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                'products.stock_quantity',
                'products.cost_price',
                'products.selling_price',
                'brands.name as brand_name',
                'categories.name as category_name',
                'sub_categories.name as subcategory_name',
                'qualitys.name as quality_name'
            )
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('sub_categories', 'products.subcategory_id', '=', 'sub_categories.id')
            ->join('qualitys', 'products.quality_id', '=', 'qualitys.id')
            ->get();

        return response()->json($data);
    }

    public function create()
    {
        $brands = DB::table('brands')->select('id', 'name')->get();
        $categories = DB::table('categories')->select('id', 'name')->get();
        $qualities = DB::table('qualitys')->select('id', 'name')->get();

        return view('admin.products.create', [
            'pageTitle' => __('messages.add_products'),
            'heading' => __('messages.add_products'),
            'brands' => $brands,
            'categories' => $categories,
            'qualities' => $qualities,
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.products'), 'url' => route('products.index'), 'active' => false],
                ['label' => __('messages.create'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'sku' => 'required|string|max:191|unique:products,sku',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => [
                // 'required',
                'exists:sub_categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    $subCategory = DB::table('sub_categories')
                        ->where('id', $value)
                        ->where('category_id', $request->category_id)
                        ->first();
                    if (!$subCategory) {
                        $fail(__('messages.invalid_subcategory'));
                    }
                },
            ],
            'quality_id' => 'required|exists:qualitys,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('image');

        if ($image = $request->file('image')) {
            $destinationPath = public_path('upload/image/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            if (!is_writable($destinationPath)) {
                return response()->json(['error' => __('messages.server_error')], 500);
            }
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $data['image'] = 'upload/image/' . $profileImage; // Store full path
        }

        Products::create($data);

        session()->flash('success', __('messages.product_created'));

        return response()->json([
            'message' => __('messages.product_created'),
            'redirect' => route('products.index')
        ], 201);
    }

    public function edit($id)
    {
        $product = Products::with(['brand', 'category', 'subCategory', 'quality'])->findOrFail($id);
        $brands = DB::table('brands')->select('id', 'name')->get();
        $categories = DB::table('categories')->select('id', 'name')->get();
        $qualities = DB::table('qualitys')->select('id', 'name')->get();
        $subcategories = DB::table('sub_categories')
            ->select('id', 'name')
            ->where('category_id', $product->category_id)
            ->get();

        return response()->json([
            'product' => $product,
            'brands' => $brands,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'qualities' => $qualities
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'sku' => 'required|string|max:191|unique:products,sku,' . $id,
            // 'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => [
                // 'required',
                'exists:sub_categories,id',
                function ($attribute, $value, $fail) use ($request) {
                    $subCategory = DB::table('sub_categories')
                        ->where('id', $value)
                        ->where('category_id', $request->category_id)
                        ->first();
                    if (!$subCategory) {
                        $fail(__('messages.invalid_subcategory'));
                    }
                },
            ],
            'quality_id' => 'required|exists:qualitys,id',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('image');

        if ($image = $request->file('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                if (is_writable(public_path($product->image))) {
                    unlink(public_path($product->image));
                }
            }
            $destinationPath = public_path('upload/image/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            if (!is_writable($destinationPath)) {
                return response()->json(['error' => __('messages.server_error')], 500);
            }
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $data['image'] = 'upload/image/' . $profileImage; // Store full path
        }

        $product->update($data);

        session()->flash('success', __('messages.product_updated'));

        return response()->json([
            'message' => __('messages.product_updated'),
            'redirect' => route('products.index')
        ], 200);
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);

        $hasSaleItems = SaleItem::where('product_id', $product->id)->exists();

        if ($hasSaleItems) {
            return response()->json([
                'message' => __('messages.product_cannot_be_deleted_has_sales')
            ], 400);
        }

        if ($product->image && file_exists(public_path('upload/image/' . $product->image))) {
            if (is_writable(public_path('upload/image/' . $product->image))) {
                unlink(public_path('upload/image/' . $product->image));
            }
        }

        // Delete the product
        $product->delete();

        session()->flash('success', __('messages.product_deleted_successfully'));

        return response()->json([
            'message' => __('messages.product_deleted_successfully')
        ], 200);
    }



    public function getSubCategories(Request $request)
    {
        $subCategories = DB::table('sub_categories')
            ->select('id', 'name')
            ->where('category_id', $request->category_id)
            ->get();
        return response()->json($subCategories);
    }
}
