@extends('layouts.main')

@section('title','Admin Permissions')

@section('content1')
    <div class="row">
        <div class="col-6">
            <h3 class="text-center">Roles</h3>
            <div class="row">
                <div class="col">
                    <a class="btn btn-primary" href="{{ route('admin.roles.create') }}"><i class="fal fa-plus fa-sm"></i> Add Category</a>
                </div>
                <div class="col text-right">
                    <a class="btn btn-primary" href="{{ route('admin.permissions.create') }}"><i class="fal fa-plus fa-sm"></i> Add Permission</a>
                </div>
            </div>

            <table class="table table-hover table-bordered" style="margin-top: 20px;">
                @foreach ($roles AS $role)
                    <tr class="del-role-{{ $role->id }}">
                        <td><a href="{{ route('admin.roles.edit',$role->id) }}">{{ $role->name }}</a></td>
                        <td class="text-center">
                            <a class="text-danger deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.roles.destroy',$role->id) }}" data-id="{{ $role->id }}" data-section="role">Delete</a>
                        </td>
                    </tr>
                    @foreach ($role->permissions()->orderBy('orderval')->orderBy('name')->get() AS $permission)
                        <tr class="del-permission-{{ $permission->id }}">
                            <td class="text-right"><a href="{{ route('admin.permissions.edit',$permission->id) }}">{{ $permission->orderval }}) {{ $permission->name }}</a></td>
                            <td class="text-center">
                                <a class="text-danger deletejson" data-token="{{ csrf_token() }}" data-url="{{ route('admin.permissions.destroy',$permission->id) }}" data-id="{{ $permission->id }}" data-section="permission">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>

@endsection
