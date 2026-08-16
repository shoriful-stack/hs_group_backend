<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    public function create()
    {
        $roles = Role::query()->pluck('name', 'id');
        $branches = Branch::query()->pluck('name', 'id');
        return view('user.create', compact('roles', 'branches'));
    }

    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->name;
            $user->branch_id = $request->branch_id;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;
            $user->save();

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    public function edit(User $user)
    {
        $roles = Role::query()->pluck('name', 'id');
        $branches = Branch::query()->pluck('name', 'id');
        return view('user.edit', compact('user', 'roles', 'branches'));
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $user->name = $request->name;
            $user->branch_id = $request->branch_id;
            $user->role_id = $request->role_id;
            $user->email = $request->email;
            $user->is_active = $request->status;
            $user->save();

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $exp) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $exp->getMessage());
        }
    }

    public function destroy() {
        //
    }

    public function search(Request $request) {
        try {
            $user = User::query()
                ->when($request->q, function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                })
                ->when($request->status !=null, fn($query) => $query->where('status', $request->status))
                ->select('id', 'name')
                ->limit(20)
                ->get();

            return response()->json($user);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Sorry! not found'], 404);
        }
    }

    public function resetPassword(User $user)
    {
        try {
            DB::beginTransaction();
            // Set default password
            $defaultPassword = strstr($user->email, '@', true);

            // Reset the password
            $user->password = Hash::make($defaultPassword);
            $user->save();
            DB::commit();
            return ReturnMessage::customMessage('success', 'Password has been reset to default successfully. ' . $defaultPassword);
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
