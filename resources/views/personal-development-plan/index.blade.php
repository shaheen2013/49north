@extends('layouts.main')
@include('modal')
@section('content1')


    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-sm-12">

                    <br>
                </div>
                <div class="col-sm-12" id="pending_div">
                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" name="archive_date" id="archive_date" placeholder="Select Date"
                                       class="form-control-new" onChange="personal_development_archive_search()">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait-his"></div>
                        </div>
                        <div class="col-sm-9">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal"
                               data-target="#personal_development_modal"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Action</th>

                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="personal_development_archive">


                                </tbody>
                            </table>
                            <div id="paginate-new"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <div id="personal_development_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="create_title" class="">Title</label>
                                    <input type="text" id="create_title" name="title" class="form-control"
                                           placeholder="Insert text here">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="create_description" class="">Description</label>
                                    <input type="text" id="create_description" name="description" class="form-control"
                                           placeholder="Insert text here">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">

                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="create_start_date" class="">Start Date</label>
                                    <input type="date" placeholder="Select Date" class="flatpickr form-control"
                                           name="start_date" id="create_start_date">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="create_end_date" class="">End Date</label>
                                    <input type="date" placeholder="Select Date" class="flatpickr form-control"
                                           name="end_date" id="create_end_date">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">

                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="company" class="">Mentor</label>
                                    <select class="select_status form-control" name="emp_id" id="create_emp_id">
                                        <option value="">Select</option>
                                        @foreach($user as $usr)
                                            <option value="{{ $usr->id }}">{{ $usr->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="create_personal_development(event)"
                                            class="btn-dark contact_btn" data-form="expences" id="create">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i
                                            class="fa fa-arrow-left"></i>  Return to Personal Development Plan Reports</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <div id="personal_development_edit_modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form action="" id="personal_development_update_form">
                            <input type="hidden" id="personal_development_update_id" name='id'>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_title" class="">Title</label>
                                        <input type="text" id="edit_title" name="title" class="form-control"
                                               placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_description" class="">Description</label>
                                        <input type="text" id="edit_description" name="description" class="form-control"
                                               placeholder="Insert text here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_start_date" class="">Start Date</label>
                                        <input type="date" placeholder="Select Date" class="flatpickr form-control"
                                               name="start_date" id="edit_start_date">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_end_date" class="">End Date</label>
                                        <input type="date" placeholder="Select Date" class="flatpickr form-control"
                                               name="end_date" id="edit_end_date">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="edit_emp_id" class="">Mentor</label>
                                        <select class="select_status form-control" name="emp_id" id="edit_emp_id">
                                            <option value="">Select</option>
                                            @foreach($user as $usr)
                                                <option value="{{ $usr->id }}">{{ $usr->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" onclick="update_personal_development()"
                                                class="btn-dark contact_btn" data-form="expences" id="create">Save
                                        </button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i
                                                class="fa fa-arrow-left"></i>  Return to Personal Development Plan Reports</span>
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

        let id = from = to = archive_from = archive_to = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            from = formatDate(new Date(y, m - 1, 0));
            to = formatDate(new Date());
            personal_development_archive_search();

            $("#pending_span").click(function () {
                $("#pending_span").addClass("active-span");
                $("#historical_span").removeClass("active-span");
                $("#pending_div").show();
                $("#historical_div").hide();

            });

            $('#archive_date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [from, to],
                onChange: function (selectedDates, dateStr, instance) {
                    archive_from = formatDate(selectedDates[0]);
                    archive_to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            archive_from = archive_to = null;
                        }

                        personal_development_archive_search();
                    }
                },
            });
        });

        function create_personal_development(event) {
            event.preventDefault();
            $('#create').attr('disabled', 'disabled');
            var title = $('#create_title').val();
            var description = $('#create_description').val();
            var start_date = $('#create_start_date').val();
            var end_date = $('#create_end_date').val();
            var emp_id = $('#create_emp_id').val();

            var data = {
                title: title,
                description: description,
                start_date: start_date,
                end_date: end_date,
                emp_id: emp_id,

            }
            // console.log(data)
            if (title == '' || description == '' || start_date == '' || end_date == '' || emp_id == '') {
                $.toaster({message: 'Field is required!', title: 'Required', priority: 'danger'});
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
                // url: "/mileage/journal/store",
                url: "{{ route('personal-development-plan.store') }}",
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                    $('#journal-modal').modal('hide');
                    // benifits_pending_new();
                    personal_development_archive_search();
                }

            });
        }


        function personal_development_archive_search() {

            let data = {
                from: archive_from,
                to: archive_to,
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',

                url: "{{ route('personal-development-plan.archive') }}",
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

                                let html = date = '';

                                for (let index = 0; index < data.length; index++) {
                                    if (data[index].start_date != null && data[index].start_date != '') {
                                        time = data[index].start_date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '-';
                                    }

                                    html += `<tr>
                                   <td> ${date} </td>
                                   <td>${data[index].description} </td>
                                   <td class="text-center">

                                    </td>
                                    <td class="action-box">
                                        <a href="/personal-development-plan/show/${data[index].id}"> View</a>
                                        <a href="javascript:void(0);" onclick="OpenEditDevelopmentModel('${data[index].id}') ">EDIT</a>
                                        <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}')">DELETE</a>
                                    </td>
                               </tr>
                               <tr class="spacer"></tr>`;
                                }
                                $('#personal_development_archive').html(html);
                            }
                        });
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function OpenEditDevelopmentModel(id) {
            $('#personal_development_update_id').val(id);
            $('#personal_development_edit_modal').modal();
            $.ajax({
                type: 'GET',
                url: "/personal-development-plan/edit/" + id,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        let mentor = '';
                        let selecteds = '';
                        for (let i = 0; i < results.data.user.length; i++) {
                            if (results.data.user[i].id === results.data.emp_id) {
                                selecteds = 'selected';
                            }
                            mentor += ` <option value="${results.data.user[i].id}" ${selecteds}>${results.data.user[i].name}</option>`;
                            selecteds = '';
                        }
                        
                        $('#edit_title').val(results.data.title);
                        console.log(results.data.title);
                        $('#edit_description').val(results.data.description);
                        $('#edit_start_date').val(results.data.start_date.split(' ')[0]);
                        $('#edit_end_date').val(results.data.end_date.split(' ')[0]);

                        $('#edit_emp_id').html(mentor);
                        $('#edit_emp_id').val(results.data.emp_id);

                        $('#update').attr('onclick', 'update_personal_development(' + id + ')');
                        $('#update').attr('data-id', id);

                        $('#edit_start_date').flatpickr({
                            mode: "range",
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.start_date,
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

                        $('#edit_end_date').flatpickr({
                            mode: "range",
                            altInput: true,
                            altFormat: 'j M, Y',
                            defaultDate: results.data.end_date,
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

        function update_personal_development() {
            let id = $('#personal_development_update_id').val();
            $('#update').attr('disabled', 'disabled');

            $.ajax({
                method: "POST",
                url: "/personal-development-plan/update/" + id,
                data: new FormData(document.getElementById('personal_development_update_form')),
                dataType: 'JSON',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    personal_development_archive_search();
                    $('#personal_development_edit_modal').modal('hide');
                    $('#update').removeAttr('disabled');
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
                        url: "/personal-development-plan/destroy/" + id,
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
