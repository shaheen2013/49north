@extends('layouts.main')
@include('modal')
@section('content1')
    <div class="container-fluid">

        <div class="tab-pane employeeagreements" id="nav-agreements" role="tabpanel" aria-labelledby="nav-agreements-tab">

            <!--- employee agreement   -->
            <h3>Agreement</h3>
            <div style="width:100%;">
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th>Employee Agreement</th>
                        <th>Code of Conduct</th>
                    </tr>
                    </thead>

                    @foreach ($users as $user)
                        <tbody>
                        <tr style="margin-bottom:10px;">
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                @if($user->activeAgreement)
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Edit</a>
                                    <a href="{{asset('agreement/'.$user->activeAgreement->agreement)}}" target="_blank">View</a>
                                    <a href="javascript:void(0);" onclick="delete_agreement('{{$user->activeAgreement->id}}','EA')" class="down">DELETE</a>
                                @else
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Upload</a>
                                @endif

                                {{-- display amendments --}}

                                @foreach ($user->activeAgreement->amendments AS $amendment)
                                    <div class="clearfix"></div>
                                    <br>{{ $loop->iteration }})
                                    <a href="{{asset('agreement/'.$amendment->agreement)}}" target="_blank">View</a><br>
                                    <a href="javascript:void(0);" onclick="delete_agreement('{{$user->activeAgreement->id}}','EA')" class="down">DELETE</a>
                                @endforeach
                            </td>

                            <td>
                                @if($user->activeCodeofconduct)
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Edit</a>
                                    <a href="{{asset('codeofconduct/'.$user->activeCodeofconduct->coc_agreement)}}" target="_blank">View</a>

                                    <a href="javascript:void(0);" onclick="delete_agreement('{{$user->activeCodeofconduct->id}}','COC')" class="down">DELETE</a>

                                <!--<a class="btn btn-danger deletejson" data-token="{{ csrf_token() }}"
                                           data-url="{{ url('delete_agreement',$user->id,'COC') }}" data-id="{{ $user->id }}"
                                           >Delete</a>-->


                                @else
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Upload</a>
                                @endif

                            </td>

                        </tr>
                        <tr class="spacer"></tr>

                        <tbody>
                    @endforeach

                </table>
            </div>

        </div><!-------------end--------->

    </div>

@endsection
