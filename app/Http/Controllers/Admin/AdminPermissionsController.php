<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{Request,Response};
use Illuminate\View\View;
use Spatie\Permission\Models\{Permission,Role};
use App\Http\Controllers\Controller;

class AdminPermissionsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index () {
        $roles = Role::with('permissions')->orderBy('orderval')->get();
        $permissions = Permission::pluck('name','id');

        return view('admin.permission.admin-permission-index', compact('roles', 'permissions'));
    }

    /**
     * @return Factory|View
     */
    public function create () {
        $permission = new Permission();
        $roles = Role::orderBy('orderval')->pluck('name','id');
        return view('admin.permission.admin-permission-edit', compact('permission','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store (Request $request) {
        $input = $request->except(['_token','role']);
        $roles = $request->input('role',[]);

        if ($id = $request->input('id')) {
            $permission = Permission::find($id);
            $permission->update($input);
            session()->flash('alert-success','Permission Updated');
        }
        else {
            $permission = Permission::create($input);
            session()->flash('alert-success','Permission Created');
        }

        // removes old roles and replaces with this
        $permission->syncRoles($roles);

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show ($id) {
        //
    }

    /**
     * @param Permission $permission
     *
     * @return Factory|View
     */
    public function edit (Permission $permission) {
        $roles = Role::orderBy('orderval')->pluck('name','id');
        $rolePermissions = $permission->roles()->pluck('id','id')->first();

        return view('admin.permission.admin-permission-edit',compact('permission','roles','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update (Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     *
     * @return Response
     * @throws \Exception
     */
    public function destroy (Permission $permission) {
        $permission->delete();
        return response()->json(['success' => true]);
    }
}
