{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.main')

@section('title', 'Users')

@section('content1')


    <h1><i class="fa fa-users"></i> User Administration <a href="{{ route('roles.index') }}"
                                                           class="btn btn-default pull-right">Roles</a>
        <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
    <hr>

    <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th>User Roles</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @php $delSection = 'users'; @endphp
            @foreach ($users as $user)
                <tr class="del-{{ $delSection }}-{{ $user->id }}">

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('F d, Y h:ia') : 'N/A' }}</td>
                    <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}

                    <td class="text-center">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                        <a class="btn btn-danger deletejson" data-token="{{ csrf_token() }}"
                           data-url="{{ route('users.destroy',$user->id) }}" data-id="{{ $user->id }}"
                           data-section="{{ $delSection }}">Delete</a>
                        {{--<a class="text-danger deletejson" data-token="{{ csrf_token() }}"
                           data-url="{{ route('users.destroy',$user->id) }}" data-id="{{ $user->id }}"
                           data-section="{{ $delSection }}"><i class="fal fa-trash-alt"></i></a>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


@endsection
