<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;

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
        return view('admin.dashboard.main');
    }
}
