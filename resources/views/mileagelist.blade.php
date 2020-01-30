@extends('layouts.main')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <h3>
                            <span class="active-span clickable" id="pending_span" onclick="searchPendingMileagePage()">Pending </span> |
                            <span class="clickable" id="historical_span" onclick="searchHistoryMileagePage()"> Historical</span>
                        </h3>
                        <br>
                    </div>
                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            @admin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Search employee" onkeyup="searchPendingMileagePage()" class="form-control-new" name="search" id="search"><span class="remove-button" onclick="document.getElementById('search').value = '';searchPendingMileagePage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            @endadmin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" name="date" id="date" placeholder="Select Date" class="form-control-new" onChange="searchPendingMileagePage()">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div id="wait"></div>
                            </div>
                            <div class="@admin col-sm-7 @else col-sm-8 @endadmin">
                                <a href="javascript:void(0)" onclick="$('#mileage-modaledit input').val(''); $('#update').attr('onclick', 'update_mileage(0);');" class="_new_icon_button_1" data-toggle="modal" data-target="#mileage-modaledit">
                                    <i class="fa fa-plus"></i> </a>
                            </div>
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employee</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        @admin
                                        <th class="text-center">Action</th>
                                        @endadmin
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_mileagelist" id="mileage_pending">
                                    <tbody>
                                </table>
                                <div id="paginate"></div>
                            </div>
                        </div>
                    </div>
                    <div id="historical_div" class="col-sm-12" style="display:none;">
                        <div class="row">
                            @admin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Search employee" onkeyup="searchHistoryMileagePage()" class="form-control-new" name="history_search" id="history_search"><span class="remove-button" onclick="document.getElementById('history_search').value = '';searchHistoryMileagePage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            @endadmin
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" name="history_date" id="history_date" placeholder="Select Date" class="form-control-new" onChange="searchHistoryMileagePage()">
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
                                        <th>Employee</th>
                                        <th>Reason for mileage</th>
                                        <th>Total Km</th>
                                        <th>Status</th>
                                        @admin
                                        <th class="text-center">Action</th>
                                        @endadmin
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_expence_ajax" id="mileage_history">

                                    </tbody>
                                </table>
                                <div id="paginate-new"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- Mileage Modal edit ---->
    <div id="mileage-modaledit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_companyname" class="">Company</label>
                                    <select class="select_status form-control" name="companyname" id="edit_companyname">
                                        <option>Select</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->companyname}}">{{$company->companyname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_date" class="">Date</label>
                                    <input type="text" placeholder="Select Date" name="date" class="flatpickr form-control" id="edit_date">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_vehicle" class="">Vehicle</label>
                                    <input type="text" id="edit_vehicle" name="vehicle" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_kilometers" class="">No of kilometers</label>
                                    <input type="number" id="edit_kilometers" name="kilometers" class="form-control" placeholder="Insert figure here">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    <label for="edit_reasonformileage" class="">Reason for mileage</label>
                                    <input type="text" id="edit_reasonformileage" name="reasonformileage" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" id="update" onclick="update_mileage(id)" class="btn-dark contact_btn" data-form="expences">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Mileage</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

        let id = from = to = history_from = history_to = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();

            var today = new Date();
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));

            searchPendingMileagePage();

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

                        searchPendingMileagePage();
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

                        searchHistoryMileagePage();
                    }
                },
            });
        });

        function OpenEditMileageModel(id) {
            console.log(id);
            $('#mileage-modaledit').modal();
            $.ajax({
                type: 'POST',
                data: {id: id},
                url: "{{ route('mileage.edit') }}",
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        let company = '';
                        let selecteds = '';
                        for (let i = 0; i < results.data.companies.length; i++) {
                            if (results.data.companies[i].id === results.data.mileage.company) {
                                selecteds = 'selected';
                            }
                            company += ` <option value="${results.data.companies[i].id}" ${selecteds}>${results.data.companies[i].companyname}</option>`;
                            selecteds = '';
                        }
                        $('#edit_companyname').html(company);

                        $('#edit_date').val(results.data.mileage.date.split(' ')[0]);
                        $('#edit_vehicle').val(results.data.mileage.vehicle);
                        $('#edit_kilometers').val(results.data.mileage.kilometers);
                        $('#edit_reasonformileage').val(results.data.mileage.reasonmileage);
                        $('#update').attr('onclick', 'update_mileage(' + id + ')');

                        $('#edit_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.mileage.date,
                            onChange: function (selectedDates, dateStr, instance) {
                                from = formatDate(selectedDates[0]);
                                to = formatDate(selectedDates[1]);
                                if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                                    if (selectedDates[0] === undefined) {
                                        from = to = null;
                                    }
                                }
                            },
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function update_mileage(id) {
            $('#update').attr('disabled', 'disabled');

            const data = {
                company: $('#edit_companyname').val(),
                date: $('#edit_date').val(),
                vehicle: $('#edit_vehicle').val(),
                kilometers: $('#edit_kilometers').val(),
                reasonmileage: $('#edit_reasonformileage').val(),
                id: id
            };

            $.ajax({
                method: "POST",
                url: "{{ route('mileage.update') }}",
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    searchPendingMileagePage();
                    $('#mileage-modaledit').modal('hide');
                    $('#update').removeAttr('disabled');
                }

            });
        }

        function searchPendingMileagePage() {
            let search = $('#search').val();

            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }

            // console.log(date);
            let data = {
                search: search,
                from: from,
                to: to,

            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('mileage.search-pending-mileage') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = '';
                                let action = '';
                                let date = '';
                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date !== null && data[index].date !== '') {
                                        var time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    let admin_user = '{{ auth()->user()->is_admin }}';
                                    // console.log(admin_user);

                                    if (admin_user == 1) {
                                        action = `<a href="javascript:void(0)" data-toggle="tooltip" title="Reject!" onclick="mileage_reject('${data[index].id}')"><i class="fa fa-ban"></i></a>
                                        <a href="javascript:void(0)" data-toggle="tooltip" title="Approved" onclick="mileage_approve('${data[index].id}')"><i class="fa fa-check-circle"></i></a>`;
                                    } else {
                                        action = '';
                                    }

                                    html += `<tr>
                                        <td> ${date} </td>
                                        <td> ${data[index].employee.firstname + ' ' + data[index].employee.lastname} </td>
                                        <td> ${data[index].reasonmileage} </td>
                                        <td> ${data[index].kilometers} </td>`;

                                        html += `

                                        <td class="text-center">
                                            <a href="javascript:void(0)" data-toggle="tooltip" title="Approved" onclick="mileage_approve('${data[index].id}')"><i class="fa fa-check-circle"></i></a>

                                            ${action}
                                        </td>`;

                                    html += `
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="OpenEditMileageModel('${data[index].id}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}')">DELETE</a>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;

                                }
                                $('#mileage_pending').html(html);
                                setTimeout(function(){
                                    $('[data-toggle="tooltip"]').tooltip()
                                },400);
                            }
                        })
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function searchHistoryMileagePage() {
            let history_search = $('#history_search').val();

            if ($.trim(history_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }

            // console.log(date);
            let data = {
                history_search: history_search,
                history_from: history_from,
                history_to: history_to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('mileage.search-history-mileage') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#wait-his').css('display', 'none');
                        $('#paginate-new').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = admin = '';
                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date !== null && data[index].date !== '') {
                                        var time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    if (is_admin == 1) {
                                        admin = `<td class="text-center">
                                            <a href="javascript:void(0)"  data-toggle="tooltip" title="Pending" onclick="mileage_pending('${data[index].id}')"><i class="fa fa-check-circle"></i></a>
                                        </td>

                                        <td class="text-right">
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}')">DELETE</a></td>
                                        </td>`;
                                    } else {
                                        admin = `<td class="text-center">N/A</td><td></td>`;
                                    }

                                    html += `<tr>
                                                <td> ${date} </td>
                                                <td> ${data[index].employee.firstname + ' ' + data[index].employee.lastname} </td>
                                                <td> ${data[index].reasonmileage} </td>
                                                <td> ${data[index].kilometers} </td>
                                                <td> ${data[index].status == 'A' ? 'Approved' : 'Rejected'} </td>
                                                ${admin}
                                            </tr><tr class="spacer"></tr>`;
                                }
                                $('#mileage_history').html(html);
                                setTimeout(function(){
                                    $('[data-toggle="tooltip"]').tooltip()
                                },400);
                            }
                        })
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function deleteconfirm(id) {
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
                        url: "{{ route('mileage.destroy') }}",
                        data: {id: id},
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    searchPendingMileagePage()
                                    searchHistoryMileagePage()
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

        function mileage_pending(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};

            $.ajax({

                method: "POST",
                url: "/mileage/pending/" + id,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Pending', title: 'Success', priority: 'success'});
                    searchPendingMileagePage()
                    searchHistoryMileagePage()
                }
            });

        }

        function mileage_approve(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let data = {id: id};

            $.ajax({

                method: "POST",
                url: "/mileage/approve/" + id,
                data: data,
                success: function (response) {
                    $.toaster({message: 'Enabled', title: 'Success', priority: 'success'});
                    searchPendingMileagePage()
                    searchHistoryMileagePage()
                }
            });

        }

        function mileage_reject(id) {

            let data = {id: id};
            $.ajax({

                method: "POST",
                url: "/mileage/reject/" + id,
                data: data,

                success: function (response) {
                    $.toaster({message: 'Disabled', title: 'Success', priority: 'success'});
                    searchPendingMileagePage()
                    searchHistoryMileagePage()
                }
            });
        }

        // Format date
        function formatDate(date) {
            const d = new Date(date), year = d.getFullYear();
            let month = '' + (d.getMonth() + 1),
                day = '' + d.getDate();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

    </script>
@endpush
