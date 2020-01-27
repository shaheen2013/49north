@extends('layouts.main')

@section('title', 'Users')

@section('content1')
    <div class="well-default-trans">
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <h3>
                        <span class="active-span" id="pending_span" onclick="searchPendingMileagePage()">Active Plans </span>
                    </h3>
                </div>
            </div>
            <div class="col-sm-1">
                <div id="wait"></div>
            </div>
            <div class="col-sm-9">
                <div class="form-group">
                    <a href="javascript:void(0)" onclick="$('#mileage-modaledit input').val(''); $('#update').attr('onclick', 'update_mileage(0);');" class="_new_icon_button_1" data-toggle="modal" data-target="#mileage-modaledit" style="padding: 7px 12px">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input type="text" placeholder="Search employee" onkeyup="searchPlans()" class="form-control-new" name="search" id="search">
                    <span class="remove-button" onclick="document.getElementById('history_search').value = '';searchPlans()"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <input type="text" name="date" id="date" placeholder="Select Date" class="form-control-new">
                </div>
            </div>
        </div>

        <div id="wait" style="display:none;position:absolute;top:50%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>

        <table class="table _table _table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date/Time Added</th>
                <th></th>
            </tr>
            </thead>

            <tbody id="plans">

            </tbody>
        </table>

        <div id="paginate"></div>
    </div>

@endsection

@section('js')
    <script !src="">
        let from = to = null;

        $(document).ready(function(){
            var date = new Date(), y = date.getFullYear(), m = date.getMonth();
            from = formatDate(new Date(y, m, 1));
            to = formatDate(new Date(y, m + 1, 0));
            searchPlans();

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
                        searchPlans();
                    }
                },
            });
        });

        function searchPlans() {
            $('#plans').html('');
            $('#wait').css('display', 'inline-block'); // wait for loader
            let search = $('#search').val();
            let data = {
                search: search,
                from: from,
                to: to,
            };

            $.ajax({
                type: 'get',
                url: "{{ route('users.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    $('#wait').css('display', 'none');

                    if (results.status == 200) {
                        renderHTML(results.data);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function renderHTML(result) {
            $('#paginate').pagination({
                dataSource: result,
                pageSize: 10,
                totalNumber: result.length,
                callback: function(data, pagination) {
                    let html = '';
                    data.forEach(function myFunction(value, index, array) {
                        if (value.created_at != null && value.created_at != '') {
                            time = value.created_at.split(' ')[0];
                            date = new Date(time);
                            date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+", "+date.toDateString().split(' ')[3]
                        } else {
                            date = 'N/A';
                        }

                        html += `<tr class="del-{{ $delSection }}-${value.id}">
                        <td> ${value.name} ${is_admin === 1 && auth_id != value.id ? '<a class="remove-default-style" href="force-login/' + value.id + '"><i class="fa fa-sign-in"></i></a>' : ''}</td>
                        <td> ${value.email} </td>
                        <td> ${date} </td>
                        <td class="text-right">
                            <a href="{{ url('/') }}/users/${value.id}/edit">Edit</a>
                            <a class="down deletejson" data-token="{{ csrf_token() }}"
                               data-url="{{ url('/') }}/users/${value.id}" data-id="${value.id}"
                               data-section="{{ $delSection }}">Delete</a>
                        </td>
                        </tr><tr class="spacer"></tr>`;
                    });
                    $('#plans').html(html);
                }
            });
        }
    </script>
@endsection
