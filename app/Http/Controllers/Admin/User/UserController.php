<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-users')->only('index');
        $this->middleware('can:create-user')->only(array('create', 'store'));
        $this->middleware('can:edit-user')->only(array('edit', 'update'));
        $this->middleware('can:delete-user')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query();

        if ($keyword = \request('search')){
            $users->where('email', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('id', $keyword);
        }

        if (Gate::allows('show-staff-users')){
            if (\request('admin')){
                $users->where('is_superuser', 1)->orWhere('is_staff', 1);
            }
        }else{
            $users->where('is_superuser', 0)->orWhere('is_staff', 0);
        }

        $users = $users->latest()->paginate(20);
        return view('admin.users.all', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->userValidate($request);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($request->has('verify')){
            $user->markEmailAsVerified();
        }
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
//        $this->authorize('edit', $user);
//        if (Gate::allows('edit', $user)){
            return view('admin.users.edit', compact('user'));
//        }

//        abort(403, 'شما اجازه دسترسی ندارید');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users')
                    ->ignore($user->id)],
        ]);

        if (! is_null($request->password)){
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->has('verify')){
            $user->markEmailAsVerified();
        }

        alert()->success('کاربر با موفقیت ویرایش شد');
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function userValidate(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        return $data;
    }

}
