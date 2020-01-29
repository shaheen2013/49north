@extends('layouts.main')
@include('modal')
@section('content1')


    <div class="well-default-trans">
        <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
            <div class="mileage inner-tab-box">
                <div class="col-md-12">
                    <div class="col-sm-12">
                        <h3>
                            <span class="active-span" id="pending_span" onclick="searchJournalPage()">My Journal Entries</span>
                        </h3>
                        <br>
                    </div>

                    <div class="col-sm-12" id="pending_div">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" name="date" id="date" placeholder="Select Date" class="form-control-new" onChange="">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div id="wait"></div>
                            </div>
                            <div class="col-sm-9">
                                <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal"
                                   data-target="#journal-modal">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-sm-12">
                                <table class="table _table _table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="return_mileagelist" id="search_journal">
                                    <tbody>
                                </table>
                                <div id="paginate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!----- Journal Modal ---->
    <div id="journal-modal" class="modal fade bs-example-modal-lg" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <div class="row">

                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_date" class="">Date</label>
                                    <input type="text" placeholder="Select Date" name="date" id="create_date" class="flatpickr form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_vehicle" class="">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Insert title here">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    <textarea style="min-height: 100px" name="details" class="form-control" placeholder="Insert text here" id="details"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" onclick="create_journal(event)" class="btn-dark contact_btn" data-form="expences" id="create">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i>  Return to journal Reports</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- Journal Modal edit ---->

    <div id="journal-edit-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <div class="row">

                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_date" class="">Date</label>
                                    <input type="text" placeholder="Select Date" name="date" id="edit_date" class="flatpickr form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="edit_vehicle" class="">Title</label>
                                    <input type="text" id="edit_title" name="title" class="form-control" placeholder="Insert title here">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    <textarea style="min-height: 100px" name="details" class="form-control" placeholder="Insert text here" id="edit_details"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="button" id="update" onclick="update_journal('')" class="btn-dark contact_btn" data-form="expences">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i>  Return to journal Reports</span>
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
    <!--- Journal edit modal end -->

    <script type="text/javascript">

        let id = from = to = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            from = formatDate(new Date(y, m - 1, 0));
            to = formatDate(new Date());
            searchJournalPage();

            $("#pending_span").click(function () {
                $("#pending_span").addClass("active-span");
                $("#pending_div").show();


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

                        searchJournalPage();
                    }
                },
            });
        });

        function create_journal(event){
            event.preventDefault();
            $('#create').attr('disabled','disabled');
            var date = $('#create_date').val();
            var title = $('#title').val();
            var details = $('#details').val();

            var data = {
                date:date,
                title:title,
                details:details,

            }
            // console.log(data)
            if(date == '' || title == ''|| details == ''){
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
                // url: "/mileage/journal/store",
                url: "{{ route('journal.store') }}",
                data: data,
                dataType: 'JSON',
                success: function( response ) {
                    $.toaster({ message : 'Created successfully', title : 'Success', priority : 'success' });
                    $('#journal-modal').modal('hide');
                    searchJournalPage();
                }

            });
        }


        function OpenEditJournalModel(id) {
            console.log(id);
            $('#journal-edit-modal').modal();
            $.ajax({
                type: 'GET',
                url: "/journal/edit/"+id,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {

                        $('#edit_date').val(results.data.date.split(' ')[0]);
                        $('#edit_title').val(results.data.title);
                        $('#edit_details').val(results.data.details);
                        $('#update').attr('onclick', 'update_journal(' + id + ')');
                        $('#update').attr('data-id', id);

                        $('#edit_date').flatpickr({
                            mode: "range",
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

        function update_journal(id) {
            $('#update').attr('disabled', 'disabled');

            const data = {
                date: $('#edit_date').val(),
                title: $('#edit_title').val(),
                details: $('#edit_details').val(),
                id: id
            };

            $.ajax({
                method: "POST",
                url: "/journal/update/"+id,
                data: data,
                dataType: 'JSON',
                success: function (response) {
                    $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                    searchJournalPage();
                    $('#journal-edit-modal').modal('hide');
                    $('#update').removeAttr('disabled');
                }

            });
        }

        function searchJournalPage() {

            // console.log(date);
            let data = {
                from: from,
                to: to,

            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('journal.search-journal') }}",
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
                                let date = '';
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
                                        <td> ${data[index].title} </td>
                                        <td> ${data[index].details} </td>`;

                                    html += `
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="OpenEditJournalModel('${data[index].id}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}')">DELETE</a></td>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;

                                }
                                $('#search_journal').html(html);
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
                        url: "/journal/destroy/" + id,
                        dataType: 'JSON',
                        success: function (results) {

                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    searchJournalPage();
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
@endpush
