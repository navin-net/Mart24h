<?php

namespace App\Http\Controllers\Shop;
use App\Models\Banner;
use App\Models\Products;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Brand;
use App\Models\Shop;
use Illuminate\Support\Facades\View; // ✅ Add this line
use Illuminate\Support\Facades\DB; // 👈 add this

class MainController extends Controller
{
    public function __construct()
    {
        $shop = Shop::first();

        $shopDetail = (object)[
            'id' => $shop->id,
            'name' => $shop->name_shop,
            'facebook' => $shop->facebook,
            'instagram' => $shop->instagram,
            'x' => $shop->x,
            'youtube' => $shop->youtube,
            'address' => $shop->address,
            'phone' => $shop->phone,
            'email' => $shop->email,
            'open_shop_time' => $shop->open_shop_time,
            'close_shop' => $shop->close_shop,
            'description' => $shop->description,
            'logo' => $shop->logo ? asset($shop->logo) : asset('images/default-shop-logo.png'),
        ];

        View::share('shopDetail', $shopDetail); // Shared to all views
    }


    public function index()
    {
        $banners = Banner::where('status', 1)->orderBy('id')->get();
        // dd($shopDetail);  
        return view('shop.index', compact('banners'));
    }

    public function about()
    {
        return view('shop.about');
    }

    public function contact()
    {
        return view('shop.contact');
    }

    public function new_arrivals()
    {
        return view('shop.new_arrivals');
    }

    public function checkout()
    {
        return view('shop.checkout');
    }

    public function cart()
    {
        return view('shop.cart');
    }

    public function products(Request $request)
    {
        $query = Products::with(['brand', 'category', 'subCategory', 'quality', 'images']);

        // Apply filters
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->whereIn('name', (array) $request->input('category'));
            });
        }

        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->whereIn('name', (array) $request->input('brand'));
            });
        }

        if ($request->filled('max_price')) {
            $query->where('selling_price', '<=', $request->input('max_price'));
        }

        if ($request->filled('color')) {
            $colors = is_array($request->input('color')) ? $request->input('color') : [$request->input('color')];
            $query->whereIn('color', $colors);
        }

        if ($request->filled('rating') && $request->input('rating') != '0') {
            $minRating = (int) $request->input('rating');
            $query->where('rating', '>=', $minRating); // Assumes 'rating' column exists
        }

        if ($request->filled('availability')) {
            $availabilities = (array) $request->input('availability');
            if (in_array('in_stock', $availabilities) && !in_array('out_of_stock', $availabilities)) {
                $query->where('stock_quantity', '>', 0);
            } elseif (in_array('out_of_stock', $availabilities) && !in_array('in_stock', $availabilities)) {
                $query->where('stock_quantity', '=', 0);
            }
        }

        // Sorting
        switch ($request->input('sort', 'default')) {
            case 'price-low':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc'); // Assumes 'rating' column
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();

        // Transform products
        $products->getCollection()->transform(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->selling_price,
                'old_price' => $product->cost_price > $product->selling_price ? $product->cost_price : null,
                'image' => $product->image ? asset($product->image) : asset('images/placeholder.jpg'),
                'rating' => $product->rating ?? rand(5, 5), // Fallback to dummy rating
                'category' => optional($product->category)->name,
                'badge' => $product->cost_price > $product->selling_price ? 'Sale' : null,
                'color' => $product->color ?? 'Unknown',
                'badge_class' => 'bg-danger',
            ];
        });

        $categories = Categories::pluck('name', 'name');
        // $colors = Products::distinct()->pluck('color')->filter()->values();
        $colors = DB::table('colors')->pluck('slug')->filter()->values();

        $brands = Brand::select('id', 'name', 'image')->get();

        return view('shop.products', compact('products', 'categories', 'colors', 'brands'));
    }
    public function productDetail($id)
    {
        $product = Products::with('images', 'brand', 'category', 'subCategory', 'quality')->find($id);

        if (!$product) {
            abort(404, 'Product not found');
        }

        $mainImagePath = $product->image ?? ($product->images->first()->image_review ?? null);

        $thumbnails = collect();

        if ($mainImagePath) {
            $thumbnails->push((object)[
                'id' => 0,
                'image' => asset($mainImagePath),
                'thumbnail' => asset($mainImagePath),
                'alt_text' => $product->name . ' - Main Image',
            ]);
        }

        if ($product->images && $product->images->count()) {
            foreach ($product->images as $i => $img) {
                $imagePath = $img->image_review ?? $img->image ?? null;
                // Avoid duplicate if main image is also in images
                if ($imagePath && asset($imagePath) !== asset($mainImagePath)) {
                    $thumbnails->push((object)[
                        'id' => $img->id,
                        'image' => asset($imagePath),
                        'thumbnail' => asset($imagePath),
                        'alt_text' => $product->name . ' - View ' . ($i + 1),
                    ]);
                }
            }
        }

        $productDetail = (object) [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->selling_price,
            'old_price' => $product->cost_price,
            'rating' => rand(4, 5),
            'reviews' => rand(100, 200),
            'image' => $mainImagePath ? asset($mainImagePath) : null,
            'main_image' => $mainImagePath ? asset($mainImagePath) : null,
            'thumbnails' => $thumbnails,
            'availability' => $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock',
            'seller' => $product->brand->name ?? 'Unknown Seller',
            'badge' => $product->stock_quantity > 10 ? 'Hot' : 'Low Stock',
            'badge_class' => $product->stock_quantity > 10 ? 'bg-success' : 'bg-warning',
        ];
        // pp($productDetail);  

        return view('shop.product-detail', ['product' => $productDetail]);
    }

}
