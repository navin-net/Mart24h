<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select([
                    'users.id',
                    'users.name',
                    'users.email',
                    'groups.name as group_name'
                ])
                ->leftJoin('groups', 'users.group_id', '=', 'groups.id')
                ->where('users.company_id', NULL);

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-primary btn-sm editUser" data-id="' . $row->id . '">' . __('messages.edit') . '</button>
                        <button class="btn btn-danger btn-sm deleteUser" data-id="' . $row->id . '">' . __('messages.delete') . '</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $groups = DB::table('groups')->select('id', 'name')->get();
        return view('admin.users.index', [
            'pageTitle' => __('messages.list_users'),
            'groups' => $groups,
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '#', 'active' => false],
                ['label' => __('messages.users'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function create()
    {
        $groups     = DB::table('groups')->select('id', 'name')->get();
        return view('admin.users.create',  [
            'groups' => $groups,
            'pageTitle' => __('messages.list_users'),
            'breadcrumbs' => [
                ['label' => __('messages.users'), 'url' => '#', 'active' => false],
                ['label' => __('messages.add'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'group_id' => 'required|exists:groups,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'company_id' => 2, // Ensure company_id is included
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', __('messages.user_created_successfully'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:6|confirmed',
            'group_id' => 'required|exists:groups,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'group_id' => $request->group_id,
            'password' => Hash::make($request->password)
        ]);
        return response()->json(['success' => 'User updated successfully.']);
    }
    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You cannot delete your own account while logged in.'
            ], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ]);
    }


}
