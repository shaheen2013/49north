@extends('layouts.main')
@include('modal')
@section('content1')


    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <h3><span class="active-span" id="pending_span" onclick="expences_pending_new()">Pending </span> |
                        <span id="historical_span" onclick="expences_history_new()"> Historical</span>
                    </h3>
                    <div class="col-sm-12" id="pending_div">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="date" name="date" id="date" placeholder="Select Date" class="form-control-new" onChange="searchMileagePage()">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" placeholder="Search employee" onkeyup="searchMileagePage()" class="form-control-new" name="search" id="search">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a href="javascript:void(0)" onclick="$('#mileage-modaledit input').val(''); $('#update').attr('onclick', 'update_mileage(0);');" class="_new_icon_button_1" data-toggle="modal" data-target="#mileage-modaledit"> <i class="fa fa-plus"></i> </a>
                                </div>
                            <div id="wait" style="display:none;position:absolute;top:100%;left:50%;padding:2px;">
                                <img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64"/><br>Loading..
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Employee</th>
                                    <th>Reason for mileage</th>
                                    <th>Total Km</th>
                                    <th class="text-center">Action</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_mileagelist" id="mileage_search">
                                <tbody>
                            </table>
                            <div id="demo"></div>
                        </div>
                    </div>

                    <div id="historical_div" class="col-sm-12" style="display:none;">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="date" name="history_date" id="history_date" placeholder="Select Date"
                                           class="form-control-new">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" placeholder="Search employee"
                                           class="form-control-new" name="history_search" id="history_search" onkeyup="expences_history_new()">
                                </div>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-12">
                                <div id="wait" style="display:none;position:absolute;top:100%;left:50%;padding:2px;"><img
                                        src='{{ asset('img/demo_wait.gif') }}' width="64" height="64"/><br>Loading..
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                    <th>Employee</th>
                                    <th>Reason for mileage</th>
                                    <th>Total Km</th>

                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_expence_ajax" id="expense_history">


                                    </tbody>
                                </table>
                                <div id="demo-new"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- Mileage Modal edit ---->
    <div id="mileage-modaledit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                    <input type="date" placeholder="" name="date" class="form-control" id="edit_date">
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
                                    <button type="button" id="update" onclick="update_mileage(id)" class="btn-dark contact_btn" data-form="expences">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Mileage</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- Mileage edit modal end -->

    <script type="text/javascript">
        let id, from, to = null;

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
                    searchMileagePage();
                    $('#mileage-modaledit').modal('hide');
                    $('#update').removeAttr('disabled');
                }

            });
        }

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            from = formatDate(new Date(y, m, 1));
            to = formatDate(new Date(y, m + 1, 0));
            searchMileagePage();

            $('#date').flatpickr({
                mode: "range",
                defaultDate: [from, to],
                onChange: function (selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            from = to = null;
                        }

                        searchMileagePage();
                    }
                },
            });
        });

        function searchMileagePage() {
            let search = $('#search').val();

            // console.log(date);
            let data = {
                search: search,
                from: from,
                to: to,

            };
            console.log(data);

            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('mileage.search-mileage') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#demo').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = '';
                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date !== null && data[index].date !== '') {
                                        var time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }
                                    html += `<tr>
                                        <td> ${date} </td>
                                        <td> ${data[index].employee.firstname + ' ' + data[index].employee.lastname} </td>
                                        <td> ${data[index].reasonmileage} </td>
                                        <td> ${data[index].kilometers} </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" onclick="expence_approve_new('${data[index].id}')"><i class="fa fa-check-circle" title="Approved"></i></a>
                                            <a href="javascript:void(0)" title="Reject!" onclick="expence_reject_new('${data[index].id}')"><i class="fa fa-ban"></i></a>
                                        </td>
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="OpenEditMileageModel('${data[index].id}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}')">DELETE</a></td>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;
                                }
                                $('#mileage_search').html(html);
                            }
                        })
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        /*window.onload = function () {
            searchMileagePage()
        };*/

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
@endsection
