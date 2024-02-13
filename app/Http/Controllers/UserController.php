<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::where('name', '!=', 'SuperAdmin')->get();
        $permissions = Permission::all()->pluck('name');
        $currencies = Currency::all();

        return view('superadmin.user.index', ['users' => $users, 'currencies' => $currencies, 'roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'currency_id' => $request->currency_id,
            'password' => Hash::make($request['password']),
        ]);
        $user->markEmailAsVerified(); //To mark this user verified without requiring them to.
        if ($request->select_role == null) {
            $user->assignRole('Admin');
        } else {
            foreach ($request->select_role as $role) {
                $user->assignRole($role);
            }
        }
        foreach ($request->select_permission as $permission)
            $user->givePermissionTo($permission);
        // foreach (config('custom.default_permissions') as $permission)
        //     $user->givePermissionTo($permission);
        return back()->with('success', 'User Created!');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->currency_id = $request->currency_id;
        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->update();
        if ($request->select_role == null) {
            $user->syncRoles('Admin');
        } else {
            foreach ($request->select_role as $role) {
                $user->syncRoles($role);
            }
        }
        $user->syncPermissions('');
        // dd($request->select_permission);
        foreach ($request->select_permission as $permission)
            $user->givePermissionTo($permission);
        return back()->with('success', 'User Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
