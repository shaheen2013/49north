@extends('layouts.main')
@section('title', 'Additional benefits pending')
@include('modal')
@section('content1')


    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-sm-12">
                    <h3>
                        <span class="active-span clickable" id="pending_span" onclick="benefitsPending()">Pending </span> |
                        <span class="clickable" id="historical_span" onclick="benefitsHistory()"> Historical</span>
                    </h3>
                    <br>
                </div>
                <div class="col-sm-12" id="pending_div">
                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" name="pending_date" id="date" placeholder="Select Date"  class="form-control-new" onChange="benefitsPending()">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-9">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#additional_benefits_modal"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Total</th>
                                    @admin
                                    <th>Action</th>
                                    @endadmin

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="benefits_pending">

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
                                <input type="date" name="history_date" id="history_date" placeholder="Select Date" class="form-control-new" onChange="benefitsHistory()">
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
                                    <th>Description</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    @admin
                                    <th>Action</th>
                                    @endadmin

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="benefits_history">


                                </tbody>
                            </table>
                            <div id="paginate-new"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <div id="additional_benefits_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="create_date" class="">Date</label>
                                        <input type="date" placeholder="Select Date" class="flatpickr form-control" name="date" id="create_date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="create_description" class="">Description</label>
                                        <input type="text" id="create_description" name="description" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>



                            <div class="row">

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="create_total" class="">Total</label>
                                        <input type="number" id="create_total" name="total" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" onclick="createAdditionalBenefits(event)" class="btn-dark contact_btn" data-form="expences" id="create">Save
                                        </button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i>  Return to Additional Benefits Spending Reports</span>
                                    </div>
                                </div>
                            </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="additional_benefits_edit_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_date" class="">Date</label>
                                        <input type="date" placeholder="Select Date" class="flatpickr form-control" name="date" id="edit_date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_description" class="">Description</label>
                                        <input type="text" id="edit_description" name="description" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>



                            <div class="row">

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
                                        <button type="button" onclick="updateAdditionalBenefits(id)" id="update" class="btn-dark contact_btn" data-form="expences">Save
                                        </button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i>  Return to Additional Benefits Spending Reports</span>
                                    </div>
                                </div>
                            </div>

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
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));
            benefitsPending();

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

                        benefitsPending();
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

                        benefitsHistory();
                    }
                },
            });
        });

        function createAdditionalBenefits(event){
            event.preventDefault();
            $('#create').attr('disabled','disabled');
            var date = $('#create_date').val();
            var description = $('#create_description').val();
            var total = $('#create_total').val();

            var data = {
                date:date,
                description:description,
                total:total,

            }
            // console.log(data)
            if(date == '' || description == ''|| total == ''){
                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' });
                $('#create').removeAttr('disabled');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "POST",
                url: "{{ route('additional-benefits.store') }}",
                data: data,
                dataType: 'JSON',
                success: function( response ) {
                    $.toaster({ message : 'Created successfully', title : 'Success', priority : 'success' });
                    $('#journal-modal').modal('hide');
                    benefitsPending();
                    benefitsHistory();
                }

            });
        }

        function benefitsPending() {
            let data = {
                from: from,
                to: to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader

            $.ajax({
                type: 'post',
                url: "{{ route('additional-benefits.pending') }}",
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
                                let html = date = admin = action = '';

                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date != null && data[index].date != '') {
                                        time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    if (is_admin == 1) {
                                        if (data[index].pay_status == 1) {
                                            action = `<a href="javascript:void(0)" data-toggle="tooltip" title="Non-Paid" onclick="benefitNonPaid('${data[index].id}', '${data[index].routes.nonPaid}')"><i class="fa fa-usd"></i></a>`;
                                        }
                                        else{
                                            action = `<a href="javascript:void(0)" data-toggle="tooltip" title="Paid" onclick="benefitPaid('${data[index].id}', '${data[index].routes.paid}')"><i class="fa fa-usd"></i></a>`;
                                        }

                                        admin = `<a href="javascript:void(0)" data-toggle="tooltip" title="Approved" onclick="benefitApprove('${data[index].id}', '${data[index].routes.approve}')"><i class="fa fa-check-circle"></i></a>
                                        <a href="javascript:void(0)" data-toggle="tooltip" title="Reject!" onclick="benefitReject('${data[index].id}', '${data[index].routes.approve}')"><i class="fa fa-ban"></i></a>`;
                                    }

                                    html += `<tr>
                                    <td> ${date} </td>
                                    <td> ${data[index].description} </td>
                                    <td>$${data[index].total} </td>
                                    <td>
                                        ${ action }
                                        ${admin}
                                    </td>
                                    <td class="action-box">
                                        <a href="javascript:void(0);" onclick="openEditBenefitsModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}') ">EDIT</a>
                                        <a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>`;
                                }
                                $('#benefits_pending').html(html);
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

        function benefitsHistory() {

            let data = {
                from: history_from,
                to: history_to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('additional-benefits.history') }}",
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
                                let html = date = admin = action = '';

                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].date != null && data[index].date != '') {
                                        time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    if (is_admin == 1) {
                                        if (data[index].pay_status == 1) {
                                            action = `<a href="javascript:void(0)" data-toggle="tooltip" title="Non-Paid" onclick="benefitNonPaid('${data[index].id}', '${data[index].routes.nonPaid}')"><i class="fa fa-usd"></i></a>`;
                                        } else{
                                            action = `<a href="javascript:void(0)" data-toggle="tooltip" title="Paid" onclick="benefitPaid('${data[index].id}', '${data[index].routes.paid}')"><i class="fa fa-usd"></i></a>`;
                                        }

                                        admin = `<a href="javascript:void(0);" class="down" onclick="deleteConfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>`;
                                    }


                                    html += `<tr>
                                   <td> ${date} </td>
                                   <td> ${data[index].description} </td>
                                   <td> $${data[index].total} </td>
                                   <td >${data[index].status == 1 ? 'Approved' : 'Rejected'} </td>
                                   <td>
                                        ${ action }
                                    </td>
                                   <td class="action-box">
                                       ${admin}
                                   </td>
                               </tr>
                               <tr class="spacer"></tr>`;
                                }
                                $('#benefits_history').html(html);
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

        function openEditBenefitsModel(id, route, update) {
            // console.log(id);
            updateRoute = update;
            $('#additional_benefits_edit_modal').modal();
            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {

                        $('#edit_date').val(results.data.date.split(' ')[0]);
                        $('#edit_description').val(results.data.description);
                        $('#edit_total').val(results.data.total);
                        $('#update').attr('onclick', 'updateAdditionalBenefits(' + id + ')');
                        $('#update').attr('data-id', id);

                        $('#edit_date').flatpickr({
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.date,
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

        function updateAdditionalBenefits(id) {
            $('#update').attr('disabled', 'disabled');

            const data = {
                date: $('#edit_date').val(),
                description: $('#edit_description').val(),
                total: $('#edit_total').val(),
                id: id
            };

            $.ajax({
                method: "POST",
                url: updateRoute,
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    searchJournalPage();
                    $('#additional_benefits_edit_modal').modal('hide');
                    $('#update').removeAttr('disabled');
                }

            });
        }

        function benefitApprove(id, route) {

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
                $.toaster({message: 'Approved', title: 'Success', priority: 'success'});
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
            });

        }

        function benefitReject(id, route) {

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

        function benefitPaid(id, route) {

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
                $.toaster({message: 'Paid', title: 'Success', priority: 'success'});
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
            });

        }

        function benefitNonPaid(id, route) {

            let data = {id: id};
            $.ajax({

                method: "POST",
                url: route,
                data: data,

                success: function (response) {
                    $.toaster({message: 'Non Paid', title: 'Success', priority: 'success'});
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });
        }

        function deleteConfirm(id, route) {
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
