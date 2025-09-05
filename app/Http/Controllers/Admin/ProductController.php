<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Products;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                    'products.code',
                    'products.stock_quantity',
                    'products.cost_price',
                    'products.selling_price',
                    'brands.name as brand_name',
                    'categories.name as category_name',
                    'sub_categories.name as subcategory_name',
                    'units.name as unit_name',
                    'qualitys.name as quality_name'
                )
                ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->leftJoin('sub_categories', 'products.subcategory_id', '=', 'sub_categories.id')
                ->leftJoin('qualitys', 'products.quality_id', '=', 'qualitys.id')
                ->leftJoin('units', 'products.unit_id', '=', 'units.id')
                ->orderBy('products.id', 'DESC');
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
            'pageTitle'    => __('messages.products_list'),
            'heading'      => __('messages.products_list'),
            'description'  => __('messages.dashboard_welcome'),
            'breadcrumbs'  => [
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
                'products.code',
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
        $brands     = DB::table('brands')->select('id', 'name')->get();
        $categories = DB::table('categories')->select('id', 'name')->get();
        $qualities  = DB::table('qualitys')->select('id', 'name')->get();
        $units      = DB::table('units')->select('id', 'name')->get();
        return view('admin.products.create', [
            'pageTitle'   => __('messages.add_products'),
            'heading'     => __('messages.add_products'),
            'brands'      => $brands,
            'categories'  => $categories,
            'qualities'   => $qualities,
            'units'      => $units,
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.products'), 'url' => route('products.index'), 'active' => false],
                ['label' => __('messages.create'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'           => 'required|string|max:191',
                'code'            => 'required|string|max:191|unique:products,code',
                'brand_id'       => 'required|exists:brands,id',
                'category_id'    => 'required|exists:categories,id',
                'subcategory_id' => [
                    'nullable',
                    'exists:sub_categories,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value) {
                            $subCategory = DB::table('sub_categories')
                                ->where('id', $value)
                                ->where('category_id', $request->category_id)
                                ->first();
                            if (!$subCategory) {
                                $fail(__('messages.invalid_subcategory'));
                            }
                        }
                    },
                ],
                'quality_id'     => 'required|exists:qualitys,id',
                'cost_price'     => 'required|numeric|min:0',
                'selling_price'  => 'required|numeric|min:0',
                // 'stock_quantity' => 'required|integer|min:0',
                'description'    => 'nullable|string',
                'second_name'    => 'nullable|string|max:191',
                'unit_id'       => 'required|exists:units,id',
                'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'image_review.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $data = $request->except('image', 'image_review');

            // Upload main product image
            if ($image = $request->file('image')) {
                $destinationPath = public_path('upload/image/');
                $imageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $imageName);
                $data['image'] = 'upload/image/' . $imageName;
            }

            // Create product record
            $product = Products::create($data);

            // Upload review images
            if ($request->hasFile('image_review')) {
                foreach ($request->file('image_review') as $reviewImage) {
                    $destinationPath = public_path('upload/image/');
                    $reviewImageName = uniqid() . '.' . $reviewImage->getClientOriginalExtension();
                    $reviewImage->move($destinationPath, $reviewImageName);

                    ProductImage::create([
                        'product_id'   => $product->id,
                        'image_review' => 'upload/image/' . $reviewImageName,
                    ]);
                }
            }

            session()->flash('success', __('messages.product_created'));

            return response()->json([
                'message'  => __('messages.product_created'),
                'redirect' => route('products.index')
            ], 201);

        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace'   => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Server error occurred. Please try again.'], 500);
        }
    }

    public function edit($id)
    {
        $product      = Products::with(['brand', 'category', 'subCategory', 'quality'])->findOrFail($id);
        $brands       = DB::table('brands')->select('id', 'name')->get();
        $categories   = DB::table('categories')->select('id', 'name')->get();
        $qualities    = DB::table('qualitys')->select('id', 'name')->get();
        $units       = DB::table('units')->select('id', 'name')->get();
        $subcategories = DB::table('sub_categories')
            ->select('id', 'name')
            ->where('category_id', $product->category_id)
            ->get();

        return response()->json([
            'product'      => $product,
            'brands'       => $brands,
            'units'       => $units,
            'categories'   => $categories,
            'subcategories'=> $subcategories,
            'qualities'    => $qualities
        ]);
    }

    public function show($id)
    {
        $product = DB::table('products')
            ->select(
                'products.*',
                'brands.name as brand_name',
                'categories.name as category_name',
                'sub_categories.name as subcategory_name',
                'product_images.image_review',
                'qualitys.name as quality_name'
            )
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('sub_categories', 'products.subcategory_id', '=', 'sub_categories.id')
            ->leftJoin('qualitys', 'products.quality_id', '=', 'qualitys.id')
            ->where('products.id', $id)
            ->first();

        $images = DB::table('product_images')
            ->where('product_id', $id)
            ->pluck('image_review');
        // return response()->json(['product' => $product,'images'  => $images]);
        return view('admin.products.products_detail', [
            'product'      => $product,
            'images'       => $images,
            'pageTitle'    => __('messages.products_detail'),
            'heading'      => __('messages.products_detail'),
            'description'  => __('messages.dashboard_welcome'),
            'breadcrumbs'  => [
                ['label' => __('messages.dashboard'), 'url' => route('dashboard'), 'active' => false],
                ['label' => __('messages.products_detail'), 'url' => '', 'active' => true],
            ]
        ]);
    }



    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'           => 'required|string|max:191',
            'code'            => 'required|string|max:191|unique:products,code,' . $id,
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => [
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
            'quality_id'     => 'required|exists:qualitys,id',
            'cost_price'     => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'second_name'    => 'nullable|string|max:191',
            'unit_id'       => 'required|exists:units,id',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('image');

        if ($image = $request->file('image')) {
            // Delete old image if exists
            $oldImagePath = public_path($product->image);
            if ($product->image && file_exists($oldImagePath)) {
                @unlink($oldImagePath);
            }

            // Prepare destination path
            $destinationPath = public_path('upload/image/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Save new image file
            $newImageName = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $newImageName);

            // Store relative path to DB
            $data['image'] = 'upload/image/' . $newImageName;
        }

        $product->update($data);

        session()->flash('success', __('messages.product_updated'));

        return response()->json([
            'message'  => __('messages.product_updated'),
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
