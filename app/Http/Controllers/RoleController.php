<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse,Request};
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\{Role,Permission};

class RoleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index () {
        $roles = Role::all();//Get all roles

        return view('roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create () {
        $permissions = Permission::all();//Get all permissions

        return view('roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store (Request $request) {
        //Validate name and permissions field
        $this->validate($request, [
                'name'        => 'required|unique:roles|max:10',
                'permissions' => 'required',
            ]);

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();
        //Looping thru selected permissions
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('roles.index')->with('alert-info', 'Role' . $role->name . ' added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function show ($id) {
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Factory|View
     */
    public function edit ($id) {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update (Request $request, $id) {

        $role = Role::findOrFail($id);//Get role with the given id
        //Validate name and permission fields
        $this->validate($request, [
            'name'        => 'required|max:10|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        return redirect()->route('roles.index')->with('alert-info', 'Role' . $role->name . ' updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy ($id) {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index')->with('alert-info', 'Role deleted!');

    }
}
