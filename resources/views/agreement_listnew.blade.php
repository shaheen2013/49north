@extends('layouts.main')
@include('modal')
@section('content1')

    <div class="well-default-trans">

        <div class="tab-pane employeeagreements" id="nav-agreements" role="tabpanel" aria-labelledby="nav-agreements-tab">

            <!--- employee agreement   -->
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <input type="date" name="date" id="date" placeholder="Select Date" class="form-control-new">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <input type="text" placeholder="Search agreement" onkeyup="searchAgreement()" class="form-control-new" name="search" id="search">
                    </div>
                </div>
            </div>
            <div style="width:100%;">
                <div id="wait" style="display:none;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                <table style="width:100%;">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee Name</th>
                        <th class="text-right">Employee Agreement</th>
                        <th class="text-right">Code of Conduct</th>
                    </tr>
                    </thead>

                    <tbody id="agreement">
                    {{--@foreach ($users as $user)
                        <tr style="margin-bottom:10px;">
                            <td>{{date('d M, Y', strtotime($user->created_at))}}</td>
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

                                --}}{{-- display amendments --}}{{--
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
                    @endforeach--}}
                    <tbody>
                </table>
            </div>

        </div><!-------------end--------->

    </div>

    <script !src="">
        let is_admin = parseInt({{ auth()->user()->is_admin }});
        let from, to = null;

        $(document).ready(function(){
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            from = formatDate(new Date(y, m, 1));
            to = formatDate(new Date(y, m + 1, 0));
            searchAgreement();

            $('#date').flatpickr({
                mode: "range",
                defaultDate: [from, to],
                onChange: function(selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            from = to = null;
                        }

                        searchAgreement();
                    }
                },
            });
        });

        function searchAgreement() {
            $('#agreement').html('');
            $('#wait').css('display', 'inline-block'); // wait for loader
            let search = $('#search').val();
            let data = {
                search: search,
                from: from,
                to: to,
            };

            $.ajax({
                type: 'get',
                url: "{{ route('agreement.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    $('#wait').css('display', 'none');
                    let html, date, empAgreement, codeOfConduct, amendments = '';

                    if (results.status == 200) {
                        for (let index = 0; index < results.data.length; index++) {
                            if (results.data[index].created_at != null && results.data[index].created_at != '') {
                                time = results.data[index].created_at.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+", "+date.toDateString().split(' ')[3]
                            } else {
                                date = '-';
                            }

                            if (results.data[index].active_agreement) {
                                if (is_admin) {
                                    empAgreement = `<a href="javascript:void(0);" onclick="show_modal_agreement('${results.data[index].id}','EA')">EDIT</a>
                                                    <a href="${results.data[index].active_agreement_url}" target="_blank">View</a>
                                                    <a href="javascript:void(0);" onclick="delete_agreement('${results.data[index].active_agreement.id}','EA')" class="down">DELETE</a>`;

                                    if (results.data[index].active_agreement.amendments.length > 0) {
                                        results.data[index].active_agreement.amendments.forEach(function myFunction(value, index, array) {
                                            amendments = `<br>${index}
                                                        <a href="${value.amendment_url}" target="_blank">View</a>
                                                        <br>
                                                        <a href="javascript:void(0);" onclick="delete_agreement('${value.id}','COC')" class="down">DELETE</a>`;
                                        });

                                        empAgreement += amendments;
                                    }
                                } else {
                                    empAgreement = `<a href="${results.data[index].active_agreement_url}" target="_blank">View</a>`;

                                    if (results.data[index].active_agreement.amendments.length > 0) {
                                        results.data[index].active_agreement.amendments.forEach(function myFunction(value, index, array) {
                                            amendments = `<br>${index}
                                                        <a href="${value.amendment_url}" target="_blank">View</a>`;
                                        });

                                        empAgreement += amendments;
                                    }
                                }
                            } else {
                                empAgreement = `<a href="javascript:void(0);" onclick="show_modal_agreement('${results.data[index].id}','EA')">Upload</a>`;
                            }

                            if (results.data[index].active_codeofconduct) {
                                if (is_admin) {
                                    codeOfConduct = `<a href="javascript:void(0);" onclick="show_modal_agreement('${results.data[index].id}','COC')">EDIT</a>
                                                    <a href="${results.data[index].active_code_of_conduct_url}" target="_blank">View</a>
                                                    <a href="javascript:void(0);" onclick="delete_agreement('${results.data[index].active_codeofconduct.id}','COC')" class="down">DELETE</a>`;
                                } else {
                                    codeOfConduct = `<a href="${results.data[index].active_code_of_conduct_url}" target="_blank">View</a>`;
                                }
                            } else {
                                codeOfConduct = `<a href="javascript:void(0);" onclick="show_modal_agreement('${results.data[index].id}','COC')">Upload</a>`;
                            }

                            html += `<tr>
                                        <td> ${ date  } </td>
                                        <td> ${results.data[index].firstname+' '+results.data[index].lastname} </td>
                                        <td class="text-right">
                                            ${ empAgreement }
                                        </td>
                                        <td class="text-right">
                                            ${ codeOfConduct }
                                        </td>
                                    </tr><tr class="spacer"></tr>`;
                        }

                        $('#agreement').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        // Format date
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
    </script>

@endsection
