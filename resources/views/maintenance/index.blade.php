@extends('layouts.main')
@section('title', 'Maintenance')
@section('content1')

    <div class="well-default-trans">

        <div class="tab-pane" id="nav-maintenance" role="tabpanel" aria-labelledby="nav-maintenance-tab">
            <div class="maintenance inner-tab-box">
                <div class="col-sm-12">
                    <h3>
                        <span class="active-span clickable" id="active_ticket_span" onclick="searchMaintenance()">Active Tickets</span> |
                        <span class="clickable" id="complited_ticket_span" onclick="searchComplitedTicket()">Completed Tickets</span>
                    </h3>
                    <br>
                </div>

                <div id="active_ticket_div">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('pending_search',null,['id' => 'pending_search', 'placeholder' => 'Select employee','class' => 'form-control-new','onkeyup' => 'searchMaintenance()']) !!}
                                <span class="remove-button" onclick="document.getElementById('pending_search').value = '';searchMaintenance()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('pending_date',null,['id' => 'date', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-7">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#maintenance-modal" style="padding: 7px 12px"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <table style="width:100%;" class="table _table _table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Submited by</th>
                            @admin
                            <th></th>
                            @endadmin
                        </tr>
                        </thead>
                        <tbody class="maintanance_list_come_ajax" id="maintanance">

                        </tbody>
                    </table>
                    <div id="paginate"></div>
                </div>

                <div id="complited_ticket_div" style="display:none;">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('completed_search',null,['id' => 'completed_search', 'placeholder' => 'Select employee','class' => 'form-control-new','onkeyup' => 'searchComplitedTicket()']) !!}
                                <span class="remove-button" onclick="document.getElementById('completed_search').value = '';searchComplitedTicket()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::text('pending_date',null,['id' => 'date-completed', 'placeholder' => 'Select Date','class' => 'form-control-new']) !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait-his"></div>
                        </div>
                        <div class="col-sm-7">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#maintenance-modal" style="padding: 7px 12px"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Submited by</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="maintanance_list_come_ajax_completed_ticket" id="maintanance-completed">
                        </tbody>
                    </table>
                    <div id="paginate-completed"></div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <div id="edit-maintenance-modal" class="modal fade bs-example-modal-lg edit-maintenance-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <!-- modal come on ajax-->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        {{ Form::open(array('route' => 'maintenance.edit', 'method' => 'post', 'class' => 'maintenance1_edit')) }}

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="maintenance-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        {{ Form::open(array('route' => 'maintenance.add', 'method' => 'post', 'class' => 'maintenance1')) }}
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('subject', 'Subject') }}
                                        {{ Form::text('subject', null, array('class' => 'form-control','placeholder'=>'Insert text here','id'=>'subject')) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('website', 'Website') }}
                                        <select class="select_status form-control" name="website" id="website">
                                            <option>Select</option>
                                            <option value="Website1">Website1</option>
                                            <option value="Website2">Website2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    A brief description of your ticket
                                    <div class="text_outer">
                                        {{ Form::label('description', 'Description') }}
                                        {{ Form::text('description', null, array('class' => 'form-control','placeholder'=>'Insert text here','id'=>'description')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('priority', 'Priority') }}
                                        <select class="select_status form-control" name="priority" id="priority">
                                            <option selected disabled>Select</option>
                                            <option value="1">Low</option>
                                            <option value="2">Normal</option>
                                            <option value="3">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        {{ Form::label('category', 'Category') }}
                                        <select class="select_status form-control" name="category" id="category">
                                            <option>Select</option>
                                            @foreach($category as $category_ex_report)
                                                <option value="{{ $category_ex_report->id }}">{{ $category_ex_report->categoryname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="text_outer">
                                        {{ Form::label('employee', 'Employee') }}
                                        <select class="select2 select_status form-control" id="employee" name="user[]" multiple>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->employee_details->firstname }} {{ $user->employee_details->lastname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        {{ csrf_field() }}
                                        {!! Form::hidden('emp_id', auth()->user()->id) !!}
                                        <button type="submit" class="btn-dark contact_btn">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Maintenance</span>
                                    </div>
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript">
        let from = to = fromCompleted = toCompleted = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));
            searchMaintenance();

            $("#active_ticket_span").click(function () {
                $("#active_ticket_span").addClass("active-span");
                $("#complited_ticket_span").removeClass("active-span");
                $("#active_ticket_div").show();
                $("#complited_ticket_div").hide();

            });

            $("#complited_ticket_span").click(function () {
                $("#complited_ticket_span").addClass("active-span");
                $("#active_ticket_span").removeClass("active-span");
                $("#active_ticket_div").hide();
                $("#complited_ticket_div").show();
            });

            $('#date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function(selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);
                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            from = to = null;
                        }
                        searchMaintenance();
                    }
                },
            });

            $('#date-completed').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function(selectedDates, dateStr, instance) {
                    fromCompleted = formatDate(selectedDates[0]);
                    toCompleted = formatDate(selectedDates[1]);
                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            fromCompleted = toCompleted = null;
                        }
                        searchComplitedTicket();
                    }
                },
            });
        });

        function searchMaintenance() {
            $('#active_ticket_div').show();
            $('#complited_ticket_div').hide();
            $('#maintanance').html('');
            $('#wait').css('display', 'inline-block'); // wait for loader
            let search = $('#pending_search').val();
            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                search: search,
                from: from,
                to: to,
                id: 'maintenance',
            };

            $.ajax({
                type: 'get',
                url: "{{ route('maintenance.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    $('#wait').css('display', 'none');

                    if (results.status == 200) {
                        renderHTML(results.data, '#paginate', '#maintanance');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function renderHTML(result, id, htmlId) {
            $(id).pagination({
                dataSource: result,
                pageSize: 10,
                totalNumber: result.length,
                callback: function(data, pagination) {
                    let html = status = adminOption = action = '';
                    data.forEach(function myFunction(value, index, array) {
                        if (value.status === null) {
                            status = 'Pending';
                        }
                        else if (value.status == 1) {
                            status = "in progress";
                        }
                        else if (value.status == 2) {
                            status = "Close";
                        }

                        if (is_ticket_admin == 1 && htmlId === '#maintanance') {
                            adminOption = `<td class="text-right">
                                <a href="javascript:void(0)" data-toggle="tooltip" title="In Progress" onclick="ticketInProgress(${value.id})"><i class="fa fa-check-circle"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" title="Cancel!" onclick="ticketCancel(${value.id})"><i class="fa fa-ban"></i></a>
                            </td>`;
                        }

                        if (htmlId === '#maintanance') {
                            action = `<td class="action-box">
                                <a href="${value.routes.show}"> View</a>
                            <a href="javascript:void(0);" onclick="maintenanceEditView(${ value.id }, '${value.routes.edit}')">EDIT</a>
                            <a href="javascript:void(0);" class="down" onclick="deleteMaintenance(${ value.id }, '${value.routes.destroy}')">DELETE</a>
                        </td>`;
                        } else {
                            action = `<td></td>`;
                        }

                        html += `<tr>
                        <td> #00${value.id}</td>
                        <td> ${value.subject} </td>
                        <td> ${status} </td>
                        <td> ${value.updated_at_formatted} </td>
                        <td> ${value.employee.firstname} ${value.employee.lastname}</td>
                        ${adminOption}
                        ${action}
                    </tr><tr class="spacer"></tr>`;
                    });
                    $(htmlId).html(html);
                    setTimeout(function(){
                        $('[data-toggle="tooltip"]').tooltip()
                    },400);
                }
            });
        }

        function searchComplitedTicket() {
            $('#active_ticket_div').hide();
            $('#complited_ticket_div').show();
            $('#maintanance').html('');
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            let search = $('#completed_search').val();

            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }

            let data = {
                search: search,
                from: fromCompleted,
                to: toCompleted,
                id: 'completed',
            };

            $.ajax({
                type: 'get',
                url: "{{ route('maintenance.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    $('#wait-his').css('display', 'none');

                    if (results.status == 200) {
                        renderHTML(results.data, '#paginate-completed', '#maintanance-completed');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function ticketInProgress(id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'POST',
                url: "{{ route('maintenance.ticket_inprogress') }}",
                dataType:'html',
                data: {_token: CSRF_TOKEN ,
                    id: id},
                success:function(response)
                {
                    searchMaintenance();
                }
            });
        }

        function deleteMaintenance(id, route){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'POST',
                url: route,
                dataType:'html',
                data: {_token: CSRF_TOKEN ,
                    id: id},
                success:function(response)
                {
                    searchMaintenance();
                    swal("Tech Maintenance Inprogress Successfully","", "success");
                }
            });
        }
    </script>
@endsection
