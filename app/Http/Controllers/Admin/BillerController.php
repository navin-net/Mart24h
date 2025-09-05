<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class BillerController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('companies')
                ->leftJoin('groups', 'companies.group_id', '=', 'groups.id')
                ->leftJoin('warehouses', 'companies.warehouse_id', '=', 'warehouses.id')
                ->select(
                    'companies.id',
                    'companies.name',
                    'companies.email',
                    'companies.city',
                    'companies.number_of_houses',
                    'companies.street',
                    'companies.address',
                    'companies.phone',
                    'groups.name as group_name',
                    'warehouses.name as warehouse_name'
                )->where('companies.group_id', 2);
                return DataTables::of($query)
                    ->addColumn('action', function ($row) {
                        return '
<div class="dropdown">
    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton'.$row->id.'" data-bs-toggle="dropdown" aria-expanded="false">
    '.__('messages.action').'
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton'.$row->id.'">
        <li>
            <a class="dropdown-item" href="'.route('billers.users.add', $row->id).'" title="'.__('messages.add_user').'">
                <i class="bi bi-person-plus me-2"></i>'.__('messages.add_user').'
            </a>
        </li>
        <li>
            <a class="dropdown-item listUser" href="#" data-id="'.$row->id.'" title="'.__('messages.list_user').'">
                <i class="bi bi-people me-2"></i>'.__('messages.list_user').'
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="'.url('billers/'.$row->id.'/edit').'" title="'.__('messages.edit').'">
                <i class="bi bi-pencil-square me-2"></i>'.__('messages.edit').'
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-danger deleteBillerBtn" href="#" data-id="'.$row->id.'" title="'.__('messages.delete').'">
                <i class="bi bi-trash me-2"></i>'.__('messages.delete').'
            </a>
        </li>
    </ul>
</div>
';
                    })
                ->filterColumn('group_name', function ($query, $keyword) {
                    $query->where('groups.name', 'like', "%{$keyword}%");
                })
                ->filterColumn('warehouse_name', function ($query, $keyword) {
                    $query->where('warehouses.name', 'like', "%{$keyword}%");
                })
                ->orderColumn('group_name', 'groups.name $1')
                ->orderColumn('warehouse_name', 'warehouses.name $1')
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.billers.index', [
            'pageTitle' => __('messages.list_billers'),
            // 'groups' => $groups,
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '#', 'active' => false],
                ['label' => __('messages.billers'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function create()
    {
        $companies = DB::table('companies')->select('*')->get();
        $groups = DB::table('groups')->select('id', 'name')->get();
        $warehouses = DB::table('warehouses')->select('id', 'name')->get();

        // pp($companies);
        return view('admin.billers.create',  [
            'groups' => $groups,
            'warehouse' => $warehouses,
            'companies' => $companies,
            'pageTitle' => __('messages.list_billers'),
            'breadcrumbs' => [
                ['label' => __('messages.billers'), 'url' => '#', 'active' => false],
                ['label' => __('messages.add'), 'url' => '', 'active' => true],
            ]
        ]);    
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:companies,email',
            'address' => 'required|max:255',
            'phone' => 'required|max:20',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);
        Companies::create([
            'name' => $request->name,
            'email' => $request->email,
            'city' => $request->city,
            'number_of_houses' => $request->number_of_houses,
            'street' => $request->street,
            'address' => $request->address,
            'phone' => $request->phone,
            'group_id' => 2,
            'logo' => $request->logo ? $request->logo->store('logos', 'public') : null,
            'group_name' => 'Biller',
            'warehouse_id' => $request->warehouse_id,
        ]);

        return redirect()->route('billers.index')->with('success', __('messages.billers_created_successfully'));
    }

    public function edit($id)
    {
        $biller = Companies::findOrFail($id);
        $groups = DB::table('groups')->select('id', 'name')->get();
        $warehouses = DB::table('warehouses')->select('id', 'name')->get();

        return view('admin.billers.edit', [
            'biller' => $biller,
            'groups' => $groups,
            'warehouse' => $warehouses,
            'pageTitle' => __('messages.edit_biller'),
            'breadcrumbs' => [
                ['label' => __('messages.dashboard'), 'url' => '#', 'active' => false],
                ['label' => __('messages.settings'), 'url' => '#', 'active' => false],
                ['label' => __('messages.billers'), 'url' => '', 'active' => true],
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:companies,email,'.$id,
            'address' => 'required|max:255',
            'phone' => 'required|max:20',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $biller = Companies::findOrFail($id);
        $biller->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'city' => $request->city,
            'number_of_houses' => $request->number_of_houses,
            'street' => $request->street,
            'logo' => $request->logo ? $request->logo->store('logos', 'public') : null,
            'note' => $request->note,
            'warehouse_id' => $request->warehouse_id,
        ]);

        return redirect()->route('billers.index')->with('success', __('messages.biller_updated_successfully'));
    }

    public function listUsers($id)
    {
        $biller = Companies::with('users')->findOrFail($id);

        $biller->users->transform(function ($user) {
            $user->action = '
                <a href="'.route('billers.users.edit', $user->id).'" class="btn btn-success btn-sm" title="'.__('messages.edit_user').'">
                    <i class="bi bi-person-plus"></i>
                </a>
                <a class="btn btn-danger btn-sm deleteUserBtn" data-id="'.$user->id.'" title="'. __('messages.delete') .'">
                    <i class="bi bi-trash"></i>
                </a>';
            return $user;
        });
        return view('admin.billers.partials.user_list', compact('biller'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => __('messages.selected_billers_deleted_successfully')]);
    }

    public function addUser($id)
    {
        $biller = Companies::findOrFail($id);
        return view('admin.billers.partials.add_user', compact('biller'));
    }

    public function storeUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:companies,email,'.$id,
            'password' => 'required|min:6|confirmed',
        ]);
        $biller = Companies::findOrFail($id);
        $user = $biller->users()->create([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $biller->id,
            'group_id' => 2,
            'password' => bcrypt($request->password),
        ]);
        return redirect()
            ->route('billers.index')
            ->with('success', __('messages.user_added_successfully'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        pp($user);
        return view('admin.billers.partials.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()
            ->route('billers.index')
            ->with('success', __('messages.user_updated_successfully'));
    }

    public function destroy($id)
    {
        $biller = Companies::findOrFail($id);
        $biller->delete();

        return response()->json(['success' => __('messages.selected_billers_deleted_successfully')]);
    }
}