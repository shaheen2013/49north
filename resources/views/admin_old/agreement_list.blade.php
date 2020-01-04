@extends('layouts.main',['subnav' => 'admin.admin-subnav'])

@section('content1')

    <h3>Agreement</h3>
    <div style="width:100%;">
        <table style="width:100%;">
            <thead>
            <tr>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Employee Agreement</th>
                <th>Code Of Conduct</th>
            </tr>
            </thead>
            @if (isset($employee))
                <tbody>
                @foreach ($employee as $user)
                    <tr style="margin-bottom:10px;">
                        <td>{{$user->created_at}}</td>
                        <td>{{$user->firstname}}</td>
                        <td>
                            @if($user->agreement)
                                <a href="javascript:void(0);"
                                   onclick="show_modal_agreement('{{$user->id}}','EA')">Edit</a>
                                <a href="{{asset('agreement/'.$user->agreement)}}" target="_blank">View</a>
                            {{-- **ToDo Add Ammendment Upload --}}
                                <a href="#">**Upload Ammendment</a>
                                <a href="javascript:void(0);" onclick="delete_agreement('{{$user->id}}','EA')"
                                   class="down">DELETE</a>
                            @else
                                <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Uplaod</a>
                            @endif
                        </td>

                        <td>
                            @if($user->coc_agreement)
                                <a href="javascript:void(0);"
                                   onclick="show_modal_agreement('{{$user->id}}','COC')">Edit</a>
                                <a href="{{asset('codeofconduct/'.$user->coc_agreement)}}" target="_blank">View</a>

                                <a href="javascript:void(0);" onclick="delete_agreement('{{$user->id}}','COC')"
                                   class="down">DELETE</a>
                            @else
                                <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Uplaod</a>
                            @endif

                        </td>

                    </tr>
                    <tr class="spacer"></tr>

                @endforeach
                </tbody>
            @endif
        </table>
    </div>
    @include('modal')
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/agreement_functions.js') }}"></script>
@endpush



