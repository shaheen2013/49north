@extends('layouts.main')

@section('title', 'Users')

@section('content1')

    <h1>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
    <hr>

    <a href="{{ route('users.create') }}" class="btn btn-success">Add User</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">

            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @php $delSection = 'users'; @endphp
            @foreach ($users as $user)
                <tr class="del-{{ $delSection }}-{{ $user->id }}">

                    <td>
                        {{ $user->name }}
                        @if (Auth::user()->is_admin === 1 && $user->id != Auth::user()->id)
                            <a class="remove-default-style" href="{{ route('force-login',$user->id) }}"><i class="fa fa-sign-in"></i></a>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('F d, Y h:ia') : 'N/A' }}</td>
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
