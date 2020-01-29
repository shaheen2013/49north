@extends('layouts.main')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-sm-12">
                    <h3>
                        <span class="active-span" id="pending_span" onclick="searchMessages()">Pending </span> |
                        <span id="historical_span" onclick="searchHistoryMessages()"> Historical</span>
                    </h3>
                    <br>
                </div>
                <div class="col-sm-12" id="pending_div">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" placeholder="Search expense" class="form-control-new" name="pending_search" id="pending_search" onkeyup="searchMessages()">
                                <span class="remove-button" onclick="document.getElementById('pending_search').value = '';searchMessages()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" name="pending_date" id="date" placeholder="Select Date" class="form-control-new">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-7">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#message-modal" style="padding: 7px 12px"> <i class="fa fa-plus"></i> </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    @admin
                                    <th>Action</th>
                                    @endadmin
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="message_pending">

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
                                <input type="text" placeholder="Search expense" class="form-control-new" name="history_search" id="history_search" onkeyup="searchHistoryMessages()">
                                <span class="remove-button" onclick="document.getElementById('history_search').value = '';searchHistoryMessages()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="date" name="history_date" id="history_date" placeholder="Select Date" class="form-control-new">
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
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="message_history">


                                </tbody>
                            </table>
                            <div id="paginate-new"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-------------end--------->
    </div>

    <!--ajax come modal-->
    <div id="message-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="expences" action="{{ route('messages.store') }}" method="POST" id="message-add-form" onsubmit="storeMessage()" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text_outer">
                                        <label for="pst">Subject Line</label>
                                        <input type="text" name="subject" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text_outer">
                                        <label for="total">Description</label>
                                        <textarea style="min-height: 100px" name="description" class="form-control" placeholder="Insert text here"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="is_anonymous"> I want to remain anonymous from my co-workers
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="is_contact"> I do not want to be contacted about this
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <button type="submit" class="btn-dark contact_btn" data-form="expences">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Report a Concern</span>
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
    <div id="message-modal-edit" class="modal fade bs-example-modal-lg expense-modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="expences" action="{{ route('messages.store') }}" method="POST" id="message-update-form" onsubmit="submitUpdateForm()" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text_outer">
                                        <label for="pst">Subject Line</label>
                                        <input type="text" name="subject" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="text_outer">
                                        <label for="total">Description</label>
                                        <textarea style="min-height: 100px" name="description" class="form-control" placeholder="Insert text here"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="is_anonymous"> I want to remain anonymous from my co-workers
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="is_contact"> I do not want to be contacted about this
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <button type="submit" class="btn-dark contact_btn" data-form="expences">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Report a Concern</span>
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
    <div id="message-modal-show" class="modal fade bs-example-modal-lg expense-modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">View</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;" id="message-show">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        let id = from = to = history_from = history_to = null;

        $(document).ready(function () {
            const date = new Date(), y = date.getFullYear(), m = date.getMonth();
            from = history_from = formatDate(new Date(y, m, 1));
            to = history_to = formatDate(new Date(y, m + 1, 0));
            searchMessages();

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
                        searchMessages();
                    }
                },
            });

            $('#history_date').flatpickr({
                mode: "range",
                altInput: true,
                altFormat: 'j M, Y',
                defaultDate: [history_from, history_to],
                onChange: function (selectedDates, dateStr, instance) {
                    history_from = formatDate(selectedDates[0]);
                    history_to = formatDate(selectedDates[1]);

                    if (selectedDates[0] === undefined || (selectedDates[0] !== undefined && selectedDates[1] !== undefined)) {
                        if (selectedDates[0] === undefined) {
                            history_from = history_to = null;
                        }
                        searchHistoryMessages();
                    }
                },
            });
        });

        function searchMessages() {
            let pending_search = $('#pending_search').val();
            if ($.trim(pending_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                search: pending_search,
                from: from,
                to: to,
                id: 'pending',
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader

            $.ajax({
                type: 'get',
                url: "{{ route('messages.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 200) {
                        renderHTML(results.data, '#paginate', '#message_pending');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function searchHistoryMessages() {
            let history_search = $('#history_search').val();
            if ($.trim(history_search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }
            let data = {
                search: history_search,
                from: history_from,
                to: history_to,
                id: 'history',
            };

            $('#wait').css('display', 'inline-block'); // wait for loader
            $('#wait-his').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'get',
                url: "{{ route('messages.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 200) {
                        renderHTML(results.data, '#paginate-new', '#message_history');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function deleteConfirm(id) {
            let data = {
                _token: '{{ csrf_token() }}',
                _method: 'delete',
            };

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
                        url: "/messages/" + id,
                        data: data,
                        success: function (response) {
                            if (response.status === 200) {
                                swal("Done!", response.message, "success").then(function () {
                                    searchMessages();
                                });
                            } else {
                                swal("Error!", response.message, "error");
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

        function openEditMessageModel(id) {
            $('#message-modal-edit').modal('show');

            $.ajax({
                type: 'GET',
                url: "/messages/" + id + '/edit',
                dataType: 'JSON',
                success: function (response) {
                    if (response.status === 200) {
                        let form = $('#message-update-form');
                        form.find('input[name="subject"]').val(response.data.subject);
                        form.find('textarea[name="description"]').val(response.data.description);

                        if (response.data.is_anonymous === 1) {
                            form.find('input[name="is_anonymous"]').prop('checked', true);
                        }

                        if (response.data.is_contact === 1) {
                            form.find('input[name="is_contact"]').prop('checked', true);
                        }

                        form.attr('action', 'messages/' + id);
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }
            });
        }

        function submitUpdateForm() {
            event.preventDefault();
            let form = $('#message-update-form');

            $.ajax({
                method: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    if (response.status === 200) {
                        $.toaster({message: 'Updated successfully', title: 'Success', priority: 'success'});
                        searchMessages();
                        $('#message-modal-edit').modal('hide');
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }
            });
        }

        function statusProgress(id) {
            let data = {
                _token: '{{ csrf_token() }}',
                _method: 'put',
            };

            $.ajax({
                method: "POST",
                url: "/messages/status/" + id,
                data: data,
                success: function (response) {
                    searchMessages();
                    $.toaster({message: response.message, title: 'Success', priority: 'success'});
                }
            });
        }

        function viewMessage(id) {
            $.ajax({
                method: "get",
                url: "/messages/show/" + id,
                success: function (response) {
                    if (response.status === 200) {
                        let html = `<table class="table table-striped table-hover">
                            <tr>
                                <th>Subject</th>
                                <td>${response.data.subject}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>${response.data.description}</td>
                            </tr>
                        </table>`;

                        $('#message-show').html(html);
                        $('#message-modal-show').modal('show');
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }
            });
        }

        function storeMessage() {
            event.preventDefault();

            let form = $('#message-add-form');

            $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    if (response.status === 200) {
                        if (response.errors === undefined) {
                            swal("Done!", response.message, "success").then(function () {
                                searchMessages();
                            });
                        } else {
                            let errors = '';
                            for (let [key, value] of Object.entries(response.errors)) {
                                errors += value[0] + '<br>';
                            }
                            swal("Error!", errors, "error");
                        }
                    } else {
                        swal("Error!", response.message, "error");
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
                            status = "Closed";
                        }

                        if (is_admin == 1 && htmlId === '#message_pending') {
                            adminOption = `<td class="text-right">
                                <a href="javascript:void(0)" onclick="statusProgress(${value.id})"><i class="fa fa-check-circle" title="status change"></i></a>
                            </td>`;
                        }

                        if (htmlId === '#message_pending') {
                            action = `<td class="action-box">
                            <a href="javascript:void(0);" onclick="openEditMessageModel(${ value.id })">EDIT</a>
                            <a href="javascript:void(0);" class="down" onclick="deleteConfirm(${ value.id })">DELETE</a>
                        </td>`;
                        } else {
                            action = `<td><a href="javascript:void(0);" onclick="viewMessage(${ value.id })">VIEW</a></td>`;
                        }

                        html += `<tr>
                                    <td> ${value.created_at_formatted} </td>
                                    <td> ${value.subject}</td>
                                    ${adminOption}
                                    ${action}
                                </tr><tr class="spacer"></tr>`;
                    });
                    $(htmlId).html(html);
                }
            });

            $('#wait').css('display', 'none');
            $('#wait-his').css('display', 'none');
        }
    </script>
@endsection