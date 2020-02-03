@extends('layouts.main')
@section('content1')

    <div class="well-default-trans">
        <div class="tab-pane " id="nav-statements" aria-labelledby="nav-statements-tab">
            <div class="agreements">
                <div class="col-sm-12" id="pending_div">
                    <div class="row">
                        @if(auth()->user()->is_admin ==1)
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" placeholder="Search pay-statement" class="form-control-new" name="search"
                                       id="search" onkeyup="searchPayStatementsPage()">
                                <span class="remove-button"
                                      onclick="document.getElementById('search').value = '';searchPayStatementsPage()"><i
                                        class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        @endif
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" name="date" id="date" placeholder="Select Date"
                                       class="form-control-new" onChange="searchPayStatementsPage()">
                            </div>
                        </div>

                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        @if(auth()->user()->is_admin ==1)
                            <div class="col-sm-7">
                                <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#show_modal_paystatement" style="padding: 7px 12px;"> <i class="fa fa-plus"></i> </a>
                            </div>
                        @endif
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="payments_search">

                                </tbody>
                            </table>
                            <div id="paginate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="show_modal_paystatement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <form id="createPayForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text_outer">
                                            <label for="company" class="">Employee</label>
                                            <select class="select_status form-control" name="emp_id" id="emp_id">
                                                <option value="">Select</option>
                                                @foreach($user as $usr)
                                                    <option value="{{ $usr->id }}">{{ $usr->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text_outer">
                                            <label for="name" class="">Description</label>
                                            <input type="text" id="description" name="description" class="form-control"
                                                   placeholder="Insert text here">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text_outer">
                                            <label for="name" class="">Date</label>
                                            <input type="date" id="date" name="date" class="flatpickr form-control" placeholder="Insert text here">
                                        </div>
                                    </div>
                                    <div class="col-md-6 image-chooser">
                                        <div class="image-chooser-preview"></div>
                                        <div class="text_outer">
                                            <label for="name" class=""><i class="fa fa-fw fa-photo"></i> Upload PDF</label>
                                            <input type="file" onchange="renderChoosedFile(this)" name="pdfname" id="pdfname" class="form-control _input_choose_file">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row margin-top-30">
                                    <div class="form-group" style="width:100%;">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" id="create" onclick="create_upload(event)"
                                                    class="btn-dark contact_btn" data-form="expences">Save
                                            </button>
                                            <span class="close close-span" data-dismiss="modal" aria-label="Close"><i
                                                    class="fa fa-arrow-left"></i> Return to Paystatement</span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var from = null;
        var to = null;
        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var today = new Date();
            to = formatDate(today);
            from = formatDate(today.setDate(today.getDate()-30));
            searchPayStatementsPage();

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
                        searchPayStatementsPage();
                    }

                },
            });
        });

        function create_upload(event) {
            event.preventDefault();
            $('#create').attr('disabled', 'disabled');
            var data = new FormData(document.getElementById('createPayForm'));

            $.ajax({
                method: "POST",
                // url: "/paystatement/store", //resource route
                url: "{{ route('paystatement.store') }}",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status === 'success') {
                        $('#createPayForm')[0].reset();
                        $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                        searchPayStatementsPage();
                        $('#show_modal_paystatement').modal('hide');
                        $('#create').removeAttr('disabled');
                    } else {
                        $.toaster({message: 'Created failed', title: 'Failed', priority: 'fail'});
                    }
                }
            });
        }

        function searchPayStatementsPage() {
            let search = $('#search').val();
            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,
                from: from,
                to: to,

            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                // url: "/paystatement/search",
                url: "{{ route('paystatement.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function (data, pagination) {
                                let html = '';
                                let date = '';
                                let description = '';
                                let action = '';
                                for (let index = 0; index < data.length; index++) {

                                    if (data[index].date != null && data[index].date != '') {
                                        time = data[index].date.split(' ')[0];
                                        date = new Date(time);
                                        date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                                    } else {
                                        date = '';
                                    }

                                    if (data[index].description != null && data[index].description != '') {
                                        description = data[index].description;
                                    } else {
                                        description = '';
                                    }
                                    let admin_user = '{{ auth()->user()->is_admin }}';
                                    // console.log(admin_user);

                                    if (admin_user == 1) {
                                        action = `<a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a>`;
                                    } else {
                                        action = '';
                                    }

                                    html += `<tr>
                                <td>${data[index].employee.firstname + ' ' + data[index].employee.lastname}</td>
                                <td> ${date} </td>
                                <td>${description} </td>
                                <td class="text-right">
                                    <a href="${data[index].pdfname}" target="_blank">VIEW</a>
                                    ${action}
                                    </td>
                            </tr><tr class="spacer"></tr>`;
                                }
                                $('#payments_search').html(html);
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
