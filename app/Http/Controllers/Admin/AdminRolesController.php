<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AdminRolesController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index () {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create () {
        $activeMenu = 'admin';
        $role = new Role();

        return view('admin.permission.admin-permission-role-edit', compact('role', 'activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store (Request $request) {
        $input = $request->except(['_token']);
        // Log::debug('Role input',$input);
        if ($id = $request->input('id')) {
            $role = Role::find($id);
            $role->update($input);
            session()->flash('alert-success','Role Updated');
        }
        else {
            $role = Role::create($input);
            session()->flash('alert-success','Role Created');
        }

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
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     *
     * @return Factory|View
     */
    public function edit (Role $role) {
        $activeMenu = 'admin';
        return view('admin.permission.admin-permission-role-edit', compact('role', 'activeMenu'));
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
     * @param int $id
     *
     * @return Response
     */
    public function destroy ($id) {
        //
    }
}
