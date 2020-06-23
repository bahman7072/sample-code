<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function create(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.permissions', compact(array('user', 'roles', 'permissions')));
    }

    public function store(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        $user->permissions()->sync($request->permissions);

        alert()->success('دسترسی های کاربر ایجاد شد');
        return redirect(route('users.index'));
    }
}
