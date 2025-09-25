<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|min:6',
            'group_id'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'group_id'   => $request->group_id,
            'company_id' => null,
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user
        ], 201);
    }

    /**
     * Login (only admin users with group_id = 1)
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        if ($user->group_id == 3) {
            return response()->json([
                'error' => 'Access denied. You do not have permission to login.'
            ], 403);
        }

        try {
            $token = JWTAuth::fromUser($user);

            $user->api_token = $token;
            $user->save();


            return response()->json([
                'message' => 'Login successful',
                'token'   => $token,
                'user'    => $user
            ]);

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token, please try again'
            ], 500);
        }
    }


    /**
     * Logout and invalidate token
     */
    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
            }
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }

    /**
     * Get profile manually without middleware
     */
    public function profile(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            $user->load(['groups:id,name']);
            $user->load(['profile:user_id,dob,image']);

            return response()->json([
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'group_id'   => $user->group_id,
                'dob'        => $user->dob,
                'group_name' => $user->groups?->name,
                'dob'        => $user->profile?->dob,
                'image'      => $user->profile?->image,
            ]);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        }
    }

    public function updateProfile(Request $request)
    {
        // Validate the request
        $request->validate([
            'name'  => 'sometimes|string|max:255',
            // 'email' => 'sometimes|email|unique:users,email,' . auth()->id(),
            // 'dob'   => 'sometimes|date',
            // 'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Authenticate user via JWT
        $user = JWTAuth::parseToken()->authenticate();

        // Update basic user info
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        $user->save();

        // Update profile info
        $profile = $user->profile ?? $user->profile()->create([]);

        if ($request->has('dob')) {
            $profile->dob = $request->dob;
        }

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imageName = time() . '_' . $image->getClientOriginalName();
            $request->file('image')->storeAs('profiles', $imageName,'public');

            $profile->image = 'profiles/' . $imageName;
        }

        $profile->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => [
                'name'  => $user->name,
                'email' => $user->email,
                'dob'   => $profile->dob,
                'image' => $profile->image,
            ]
        ]);
    }


    public function getGroups()
    {
        try {
            $groups = DB::table('groups')
                ->select(
                    'groups.id',
                    'groups.name as group_name'
                )
                ->orderBy('groups.name')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $groups,
                'message' => 'Groups fetched successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch groups',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
