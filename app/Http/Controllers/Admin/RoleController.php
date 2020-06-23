<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-roles')->only('index');
        $this->middleware('can:create-roles')->only(array('create', 'store'));
        $this->middleware('can:edit-roles')->only(array('edit', 'update'));
        $this->middleware('can:delete-roles')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::query();

        if ($keyword = \request('search')){
            $roles->where('label', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%");
        }

        $roles = $roles->latest()->paginate(20);
        return view('admin.roles.all', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'label' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::create($data);
        $role->permissions()->sync($data['permissions']);

        alert()->success('مقام با موفقیت ایجاد شد')->autoclose(4000);
        return redirect(route('roles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact(array('role', 'permissions')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'label' => ['required', 'string', 'max:255'],
            'permissions' => ['required', 'array'],
        ]);

        $role->update($data);
        $role->permissions()->sync($data['permissions']);

        alert()->success('دسترسی با موفقیت ویرایش شد')->autoclose(4000);
        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        alert()->success('دسترسی "'. $role->label .'" با موفقیت حذف شد')->autoclose(4000);
        return back();
    }
}
