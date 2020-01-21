@extends('layouts.main')
@include('modal')
@section('content1')

    <div class="well-default-trans">

        <div class="tab-pane employeeagreements" id="nav-agreements" role="tabpanel" aria-labelledby="nav-agreements-tab">

            <!--- employee agreement   -->
            <h3>Agreement</h3>
            <div style="width:100%;">
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th class="text-right">Employee Agreement</th>
                        <th class="text-right">Code of Conduct</th>
                    </tr>
                    </thead>

                    @foreach ($users as $user)
                        <tbody>
                        <tr style="margin-bottom:10px;">
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->name}}</td>
                            <td class="text-right">
                                @if($user->activeAgreement)
                                    @admin
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Edit</a>
                                    @endadmin
                                    <a href="{{fileUrl($user->activeAgreement->agreement, true)}}" target="_blank">View</a>
                                    @admin
                                    <a href="javascript:void(0);" onclick="delete_agreement('{{$user->activeAgreement->id}}','EA')" class="down">DELETE</a>
                                    @endadmin
                                @else
                                    @admin
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','EA')">Upload</a>
                                    @endadmin
                                @endif

                                {{-- display amendments --}}
                                @if($user->activeAgreement['amendments'])
                                    @foreach ($user->activeAgreement['amendments'] AS $amendment)

                                        <br>{{ $loop->iteration }})
                                        <a href="{{fileUrl($amendment->agreement, true)}}" target="_blank">View</a>

                                        @admin
                                        <br>
                                        <a href="javascript:void(0);" onclick="delete_agreement('{{$user->activeAgreement->id}}','EA')" class="down">DELETE</a>
                                        @endadmin
                                    @endforeach
                                @endif
                            </td>

                            <td class="text-right">
                                @if($user->activeCodeofconduct)
                                    @admin
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Edit</a>
                                    @endadmin

                                    <a href="{{fileUrl($user->activeCodeofconduct->coc_agreement, true)}}" target="_blank">View</a>

                                    @admin
                                    <a href="javascript:void(0);" onclick="delete_agreement('{{$user->activeCodeofconduct->id}}','COC')" class="down">DELETE</a>
                                    @endadmin

                                <!--<a class="btn btn-danger deletejson" data-token="{{ csrf_token() }}"
                                           data-url="{{ url('delete_agreement',$user->id,'COC') }}" data-id="{{ $user->id }}"
                                           >Delete</a>-->


                                @else
                                    @admin
                                    <a href="javascript:void(0);" onclick="show_modal_agreement('{{$user->id}}','COC')">Upload</a>
                                    @endadmin
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
