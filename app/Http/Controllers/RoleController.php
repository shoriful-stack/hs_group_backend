<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\RolesDataTable;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('role.index');
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(RoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $role = new Role();
            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->save();

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->status = $request->status;
            $role->save();

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    public function role_permission($id)
    {
        $permissions = Permission::query()
            ->join('modules', 'permissions.module_id', '=', 'modules.id')
            ->select('permissions.name', 'permissions.module_id', 'modules.name as module_name')
            ->orderBy('modules.name')
            ->get()
            ->groupBy('module_name');
        $role = Role::find($id);
        return view('role.permission', compact('permissions', 'role'));
    }

    public function role_permission_save($id, Request $request)
    {

        try {
            DB::beginTransaction();
            $request->validate([
                'permissions' => ['required', 'array'],
                'permissions.*' => ['string']
            ]);

            $role = Role::find($id);
            $role->syncPermissions($request->permissions);
            // Refresh permissions for all users associated with this role
            $users = User::query()->where('role_id', $id)->get(); // Assuming you have a 'users' relationship defined on the Role model
            foreach ($users as $user) {
                $user->syncRoles($role); // Re-sync the user's roles to refresh permissions
            }

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
