<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Products;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }




    // Handle user registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Default role is 'user'
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle user login
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $key = 'login|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'login' => 'Too many login attempts. Please try again in ' . gmdate('i:s', $seconds) . ' minutes.',
            ])->withInput($request->only('login'));
        }

        $loginInput = $request->input('login');

        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $field => $loginInput,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id != 1) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Your account does not have permission to log in.',
                ])->withInput($request->only('login'));
            }

            RateLimiter::clear($key);
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        RateLimiter::hit($key, 180);

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login'));
    }


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Dashboard view - both user and admin
    public function dashboard()
    {
        $purchasesCount = Purchase::count();
        $brandCount = Brand::count();
        $salesCount = Sale::count();
        $productCount = Products::count();

        // Get sales totals per month (current year), grouped by month number (1-12)
        $salesMonthly = Sale::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('SUM(total_amount) as total')
        )
            ->whereYear('date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize all 12 months
        $salesData = [];
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $i; // month number 1–12
            $monthSales = $salesMonthly->firstWhere('month', $i);
            $salesData[] = $monthSales ? $monthSales->total : 0;
        }

        // / Get latest 5 sales
        $recentSales = Sale::orderBy('date', 'desc')->take(5)->get();

        // Get latest 5 updated products
        $recentProducts = Products::orderBy('updated_at', 'desc')->take(5)->get();

        // Optional: Low stock alerts (products with quantity < 5)
        $lowStockProducts = Products::where('stock_quantity', '<', 5)->orderBy('stock_quantity')->take(5)->get();


        return view('admin.dashboard.main', [
            'brandCount' => $brandCount,
            'productCount' => $productCount,
            'salesCount' => $salesCount,
            'purchasesCount' => $purchasesCount,
            'salesLabels' => $labels,
            'salesData' => $salesData,
            'recentSales' => $recentSales,
            'recentProducts' => $recentProducts,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
    public function getAlerts()
    {
        // $today = now()->toDateString();

        // ->orWhere('expiry_date', '<', $today)
        return Products::where('stock_quantity', '<=', 0)->get(['id', 'name', 'stock_quantity']);
    }
}
