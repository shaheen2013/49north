@extends('layouts.main')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-sm-12">
                    <h3>
                        <span class="active-span clickable" id="pending_span" onclick="expences_pending_new()">Pending </span> |
                        <span class="clickable" id="historical_span" onclick="expences_history_new()"> Historical</span>
                    </h3>
                    <br>
                </div>
                <div class="col-sm-12" id="pending_div">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" placeholder="Search employee" class="form-control-new" name="pending_search" id="pending_search" onkeyup="expences_pending_new()">
                                <span class="remove-button" onclick="document.getElementById('pending_search').value = '';expences_pending_new()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" name="pending_date" id="date" placeholder="Select Date"
                                       class="form-control-new" onChange="expences_pending_new()">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-7">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#expense-modal"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    @admin
                                    <th>Employee</th>
                                    @endadmin
                                    <th>Description</th>
                                    <th>Total</th>
                                    @admin
                                    <th>Action</th>
                                    @endadmin
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="expence_pending">

                                </tbody>
                            </table>
                            <div id="paginate"></div>
                        </div>
                    </div>
                </div>
                <div id="historical_div" class="col-sm-12" style="display:none;">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" placeholder="Search employee" class="form-control-new" name="history_search" id="history_search" onkeyup="expences_history_new()">
                                <span class="remove-button" onclick="document.getElementById('history_search').value = '';expences_history_new()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" name="history_date" id="history_date" placeholder="Select Date"
                                       class="form-control-new">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait-his"></div>
                        </div>
                        <div class="col-sm-7"></div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    @admin
                                    <th>Employee</th>
                                    @endadmin
                                    <th>Description</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="expense_history">


                                </tbody>
                            </table>
                            <div id="paginate-new"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <div id="expense-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="expences" action="{{url('expense/addexpense')}}" method="POST" id="addexpense-form" enctype="multipart/form-data" novalidate>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="company" class="">Company</label>
                                        <select class="select_status form-control" name="company" id="company">
                                            <option value="">Select</option>
                                            @if(auth()->user()->is_admin)
                                                @foreach($companies as $company_ex_report)
                                                    <option value="{{ $company_ex_report->id }}">{{ $company_ex_report->companyname }}</option>
                                                @endforeach
                                            @else
                                                @if(auth()->user()->employee_details && auth()->user()->employee_details->company_id)
                                                <option value="{{ auth()->user()->employee_details->company_id }}" selected>{{ auth()->user()->employee_details->company->companyname }}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="expense_date" class="">Date</label>
                                        <input type="date" placeholder="Select Date" class="flatpickr form-control" name="date" id="expense_date">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="category" class="">Category</label>
                                        <select class="select_status form-control" name="category" id="category">
                                            <option value="">Select</option>
                                            @foreach($category as $category_ex_report)
                                                <option
                                                    value="{{ $category_ex_report->id }}">{{ $category_ex_report->categoryname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="purchase" class="">Purchase via</label>
                                        <select class="select_status form-control" name="purchase" id="purchase">
                                            <option value="">Select</option>
                                            @foreach($purchases as $purchases_ex_report)
                                                <option
                                                    value="{{ $purchases_ex_report->id }}">{{ $purchases_ex_report->purchasename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="project" class="">Project</label>
                                        <select class="select_status form-control" name="project" id="project">
                                            <option value="">Select</option>
                                            @foreach($project as $project_ex_report)
                                                <option
                                                    value="{{ $project_ex_report->id }}">{{ $project_ex_report->projectname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 image-chooser">
                                    <div class="image-chooser-preview"></div>
                                    <div class="text_outer">
                                        <label for="name"><i class="fa fa-fw fa-photo"></i> Select Receipt</label>
                                        <input type="file" onchange="renderChoosedFile(this)" name="receipt" class="form-control _input_choose_file">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="description" class="">Description</label>
                                        <input type="text" id="description" name="description" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="billable"> Billable
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="display:inline-flex;">
                                            <div class="col-md-7 col-sm-7">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" id="authorization"> Received authorization
                                                </label>
                                            </div>
                                            <div class="col-md-5 col-sm-5">
                                                <input type="text" id="ireceived_auth" onkeyup="checkAuthorization('#authorization')" name="received_auth" class="form-control" placeholder="" style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="subtotal" class="">Subtotal</label>
                                        <input type="number" id="subtotal" name="subtotal" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="gst" class="">GST</label>
                                        <input type="number" id="gst" name="gst" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="pst" class="">PST</label>
                                        <input type="number" id="pst" name="pst" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="total" class="">Total</label>
                                        <input type="number" id="total" name="total" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <button type="button" onclick="storeExpense()" class="btn-dark contact_btn" data-form="expences">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Expense Reports</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="expense-modal-edit2" class="modal fade bs-example-modal-lg expense-modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form id="editExpenseForm" enctype="multipart/form-data" novalidate>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_company" class="">Company</label>
                                        <select class="select_status form-control" name="company" id="edit_company">
                                            <option value="">Select</option>
                                            @if(auth()->user()->is_admin)
                                                @foreach($companies as $company_ex_report)
                                                    <option value="{{ $company_ex_report->id }}">{{ $company_ex_report->companyname }}</option>
                                                @endforeach
                                            @else
                                                @if(auth()->user()->employee_details && auth()->user()->employee_details->company_id)
                                                    <option value="{{ auth()->user()->employee_details->company_id }}" selected>{{ auth()->user()->employee_details->company->companyname }}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_date" class="">Date</label>
                                        <input type="date" placeholder="Select Date" class="flatpickr form-control" name="date" id="edit_date">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_category" class="">Category</label>
                                        <select class="select_status form-control" name="category" id="edit_category">
                                            <option value="">Select</option>
                                            @foreach($category as $category_ex_report)
                                                <option
                                                    value="{{ $category_ex_report->id }}">{{ $category_ex_report->categoryname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_purchase" class="">Purchase via</label>
                                        <select class="select_status form-control" name="purchase" id="edit_purchase">
                                            <option value="">Select</option>
                                            @foreach($purchases as $purchases_ex_report)
                                                <option
                                                    value="{{ $purchases_ex_report->id }}">{{ $purchases_ex_report->purchasename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_project" class="">Project</label>
                                        <select class="select_status form-control" name="project" id="edit_project">
                                            <option value="">Select</option>
                                            @foreach($project as $project_ex_report)
                                                <option
                                                    value="{{ $project_ex_report->id }}">{{ $project_ex_report->projectname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 image-chooser">
                                    <div class="image-chooser-preview"></div>
                                    <div class="text_outer">
                                        <label for="name"><i class="fa fa-fw fa-photo"></i> Select Receipt</label>
                                        <span id="edit_receipt_show" style="position: relative;z-index: 5"></span>
                                        <input type="file" onchange="renderChoosedFile(this)" name="receipt" class="form-control _input_choose_file">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_description" class="">Description</label>
                                        <input type="text" name="description" id="edit_description" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="billable" id="edit_billable"> Billable
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="display:inline-flex;">
                                            <div class="col-md-7 col-sm-7">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" id="authorization-edit"> Received authorization
                                                </label>
                                            </div>
                                            <div class="col-md-5 col-sm-5">
                                                <input type="text" name="received_auth" onkeyup="checkAuthorization('#authorization-edit')" id="received_auth" class="form-control" placeholder="" style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_subtotal" class="">Subtotal</label>
                                        <input type="number" id="edit_subtotal" name="subtotal" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_gst" class="">GST</label>
                                        <input type="number" id="edit_gst" name="gst" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_pst" class="">PST</label>
                                        <input type="number" id="edit_pst" name="pst" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_total" class="">Total</label>
                                        <input type="number" id="edit_total" name="total" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <button type="button" id="update" onclick="update_expense({{ auth()->user()->id }})" class="btn-dark contact_btn" data-form="expences">
                                            Save
                                        </button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Expense Reports</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--ajax come modal-->

    <script type="text/javascript">
        let id = from = to = history_from = history_to = updateRoute = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            to = history_to = formatDate(today);
            from = history_from = formatDate(today.setDate(today.getDate()-30));
            expences_pending_new();

            $("#historical_span").click(function () {
                $("#historical_span").addClass("active-span");
                $("#pending_span").removeClass("active-span");
                $("#pending_div").hide();
                $("#historical_div").show();
            });

            $("#pending_span").click(function () {
                $("#pending_span").addClass("active-span");
                $("#historical_span").removeClass("active-span");
                $("#pending_div").show();
                $("#historical_div").hide();

            });

            $('#date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function (selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            from = to = null;
                        }

                        expences_pending_new();
                    }
                },
            });

            $('#history_date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function (selectedDates, dateStr, instance) {
                    history_from = formatDate(selectedDates[0]);
                    history_to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            history_from = history_to = null;
                        }

                        expences_history_new();
                    }
                },
            });
        });

        function expences_pending_new() {
            let pending_search = $('#pending_search').val();
            if ($.trim(pending_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                pending_search: pending_search,
                from: from,
                to: to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader

            $.ajax({
                type: 'post',
                url: "{{ route('expenses.pending') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = date = adminOption = '';

                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date != null && data[index].date != '') {
                                        time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    if (is_admin == 1) {
                                        adminOption = `<a href="javascript:void(0)" data-toggle="tooltip" title="Approved!"  onclick="expence_approve_new('${data[index].id}', '${data[index].routes.approve}')"><i class="fa fa-check-circle"></i></a>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  title="Reject!" onclick="expence_reject_new('${data[index].id}', '${data[index].routes.reject}')"><i class="fa fa-ban"></i></a>`;
                                    }

                                    html += `<tr>
                                    <td> ${date} </td>
                                    <td> ${data[index].employee.firstname == null ? '' : data[index].employee.firstname} ${data[index].employee.lastname == null ? '' : data[index].employee.lastname}</td>
                                    <td> ${data[index].description == null ? '' : data[index].description} </td>
                                    <td> ${data[index].total == null ? '' : data[index].total} </td>
                                    <td>
                                        ${adminOption}
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" onclick="OpenEditExpenseModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}') ">EDIT</a>
                                        <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>`;
                                }
                                $('#expence_pending').html(html);
                                setTimeout(function(){
                                    $('[data-toggle="tooltip"]').tooltip()
                                },400);

                            }
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function expences_history_new() {
            let history_search = $('#history_search').val();
            if ($.trim(history_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                history_search: history_search,
                from: history_from,
                to: history_to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('expenses.history') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate-new').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = admin = date = '';

                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date != null && data[index].date != '') {
                                        time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    if (is_admin == 1) {
                                        admin = `<a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>`;
                                    }

                                    html += `<tr>
                                           <td> ${date} </td>
                                           <td> ${data[index].employee.firstname == null ? '' : data[index].employee.firstname} ${data[index].employee.lastname == null ? '' : data[index].employee.lastname}</td>
                                           <td> ${data[index].description == null ? '' : data[index].description} </td>
                                           <td> ${data[index].total == null ? '' : data[index].total} </td>
                                           <td> ${data[index].status == 1 ? 'Approved' : 'Rejected'} </td>
                                           <td class="action-box">
                                               ${admin}
                                           </td>
                                       </tr>
                                       <tr class="spacer"></tr>`;
                                }
                                $('#expense_history').html(html);
                            }
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function deleteconfirm(id, route) {
            swal({
                title: "Delete?",
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'post',
                        url: route,
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {

                                    window.location.reload()
                                })
                            } else {
                                swal("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
        }

        function OpenEditExpenseModel(id, route, update) {
            updateRoute = update;
            $('#expense-modal-edit2').modal();

            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        let company = '';
                        let selecteds = '';
                        for (let i = 0; i < results.data.companies.length; i++) {
                            if (results.data.companies[i].id === results.data.expense.company) {
                                selecteds = 'selected';
                            }
                            company += ` <option value="${results.data.companies[i].id}" ${selecteds}>${results.data.companies[i].companyname}</option>`;
                            selecteds = '';
                        }

                        let category = '';
                        let selectedc = '';
                        for (let i = 0; i < results.data.category.length; i++) {
                            if (results.data.category[i].id === results.data.expense.category) {
                                selectedc = 'selected';
                            }
                            category += ` <option value="${results.data.category[i].id}" ${selectedc}>${results.data.category[i].categoryname}</option>`;
                            selectedc = '';
                        }

                        let purchase = '';
                        let selectedp = '';
                        for (let i = 0; i < results.data.purchases.length; i++) {
                            if (results.data.purchases[i].id === results.data.expense.purchase) {
                                selectedp = 'selected';
                            }
                            purchase += ` <option value="${results.data.purchases[i].id}" ${selectedp}>${results.data.purchases[i].purchasename}</option>`;
                            selectedp = '';
                        }

                        let project = '';
                        let selectedpr = '';
                        for (let i = 0; i < results.data.project.length; i++) {
                            if (results.data.project[i].id === results.data.expense.project) {
                                selectedpr = 'selected';
                            }
                            project += ` <option value="${results.data.project[i].id}" ${selectedpr}>${results.data.project[i].projectname}</option>`;
                            selectedpr = '';
                        }
                        let check = '';
                        if (results.data.expense.billable != null) {
                            check = $('#edit_billable').attr('checked', true);
                        } else {
                            check = $('#edit_billable').val(results.data.expense.billable);
                        }
                        if (results.data.expense.billable != null) {
                            check = $('#edit_billable').attr('checked', true);
                        } else {
                            check = $('#edit_billable').val(results.data.expense.billable);
                        }

                        $('#edit_company').html(company);
                        $('#edit_category').val(results.data.expense.company);
                        $('#edit_date').val(results.data.expense.date.split(' ')[0]);
                        $('#edit_category').html(category);
                        $('#edit_category').val(results.data.expense.category);
                        $('#edit_purchase').html(purchase);
                        $('#edit_purchase').val(results.data.expense.purchase);
                        $('#edit_project').html(project);
                        $('#edit_project').val(results.data.expense.project);
                        $('#edit_description').val(results.data.expense.description);
                        if (results.data.expense.receipt != null) {
                            $('#edit_receipt_show').html('<a href="{{ fileUrl() }}' + results.data.expense.receipt + '" target="_blank"><i class="fa fa-file-pdf-o"></i><a>');
                        }
                        $('#edit_billable').val(check);
                        $('#received_auth').val(results.data.expense.received_auth);
                        $('#edit_subtotal').val(results.data.expense.subtotal);
                        $('#edit_gst').val(results.data.expense.gst);
                        $('#edit_pst').val(results.data.expense.pst);
                        $('#edit_total').val(results.data.expense.total);

                        $('#update').attr('onclick', 'update_expense(' + id + ')');

                        $('#edit_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.expense.date,
                            onChange: function (selectedDates, dateStr, instance) {
                                from = formatDate(selectedDates[0]);
                                to = formatDate(selectedDates[1]);

                                if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                                    if (selectedDates[0] === undefined) {
                                        from = to = null;
                                    }

                                    expences_pending_new();
                                }
                            },
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function update_expense(id) {
            if ($('#authorization-edit').prop('checked')) {
                submitUpdateForm(id);
            } else {
                swal({
                    title: "Confirm",
                    text: "Are you sure want to update without receive authorization!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, create!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        submitUpdateForm(id);
                    } else {
                        e.dismiss;
                    }

                }, function (dismiss) {
                    return false;
                })
            }
        }

        function submitUpdateForm(id) {
            $('#update').attr('disabled', 'disabled');
            var data = new FormData(document.getElementById('editExpenseForm'));

            $.ajax({
                method: "PUT",
                url: updateRoute,
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status == 'success') {
                        $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                        expences_pending_new();
                        expences_history_new();
                        $('#expense-modal-edit2').modal('hide');
                        $('#update').removeAttr('disabled');
                    } else {
                        if (response.errors === undefined) {
                            swal("Error!", response.msg, "error");
                        } else {
                            let errors = '';
                            for (let [key, value] of Object.entries(response.errors)) {
                                errors += value[0] + '<br>';
                            }
                            swal("Error!", errors, "error");
                        }
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

        function expence_approve_new(id, route) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};

            $.ajax({
                method: "POST",
                url: route,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Enabled', title: 'Success', priority: 'success'});
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });
        }

        function expence_reject_new(id, route) {
            let data = {id: id};

            $.ajax({
                method: "POST",
                url: route,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Disabled', title: 'Success', priority: 'success'});
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });
        }

        function storeExpense() {
            event.preventDefault();

            if ($('#authorization').prop('checked')) {
                $('#addexpense-form').submit();
            } else {
                swal({
                    title: "Confirm",
                    text: "Are you sure want to create without receive authorization!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, create!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        $('#addexpense-form').submit();
                    } else {
                        e.dismiss;
                    }

                }, function (dismiss) {
                    return false;
                })
            }
        }

        function checkAuthorization(id) {
            if (event.target.value === '') {
                $(id).prop('checked', false);
            } else {
                $(id).prop('checked', true);
            }
        }
    </script>
@endsection
