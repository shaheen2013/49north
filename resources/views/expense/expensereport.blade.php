@extends('layouts.main')
@include('modal')
@section('content1')


<div class="well-default-trans">
    <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
        <div class="expense inner-tab-box">
            <div class="col-md-12">
                <h3><span class="active-span" id="pending_span" onclick="expences_pending(this.value)">Pending </span> |
                    <span id="historical_span" onclick="expense_history(this.value)"> Historical</span>
                </h3>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="date" name="date" id="date"  placeholder="Select Date" class="form-control-new" onChange="searchExpensePage()">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" placeholder="Search employee" onkeyup="searchExpensePage()" class="form-control-new" name="search" id="search">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#mileage-modal"> <i class="fa fa-plus"></i> </a>
                    </div>
                    <div class="col-sm-12" id="pending_div">
                        <div id="wait" style="display:none;position:absolute;top:100%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                        <table style="width:100%;">
                            <thead>
                            <tr>
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
                            </tr>
                            </thead>
                            <tbody class="return_expence_ajax" id="expense_search">
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>



    <div id="expense-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="expences" action="{{url('expense/addexpense')}}" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company</label>
                                        <select class="select_status form-control" name="company">
                                            <option value="">Select</option>
                                            @foreach($companies as $company_ex_report)
                                                <option value="{{ $company_ex_report->id }}">{{ $company_ex_report->companyname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Date</label>
                                        <input type="date" placeholder="" class="form-control" name="date">
                                    </div>


                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Category</label>
                                        <select class="select_status form-control" name="category">
                                            <option value="">Select</option>
                                            @foreach($category as $category_ex_report)
                                                <option value="{{ $category_ex_report->id }}">{{ $category_ex_report->categoryname }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Purchase via</label>
                                        <select class="select_status form-control" name="purchase">
                                            <option value="">Select</option>
                                            @foreach($purchases as $purchases_ex_report)
                                                <option value="{{ $purchases_ex_report->id }}">{{ $purchases_ex_report->purchasename }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Project</label>
                                        <select class="select_status form-control" name="project">
                                            <option value="">Select</option>
                                            @foreach($project as $project_ex_report)
                                                <option value="{{ $project_ex_report->id }}">{{ $project_ex_report->projectname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Select Receipt</label>
                                        <input type="file" name="receipt" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Description</label>
                                        <input type="text" id="name" name="description" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" name="billable" style="margin-left: -12.01rem;"> Billable
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="display:inline-flex;">
                                            <div class="col-md-7 col-sm-7">

                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="" style="margin-left: -7.25rem;"> Received authorization
                                                </label>

                                            </div>
                                            <div class="col-md-5 col-sm-5">
                                                <input type="text" id="name" name="received_auth" class="form-control" placeholder="" style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Subtotal</label>
                                        <input type="number" id="name" name="subtotal" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">GST</label>
                                        <input type="number" id="name" name="gst" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">PST</label>
                                        <input type="number" id="name" name="pst" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Total</label>
                                        <input type="number" id="name" name="total" class="form-control" placeholder="Insert Figure here">
                                    </div>
                                </div>
                            </div>
                            </hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <input type="submit" class="btn-dark contact_btn" value="Save" data-form="expences">
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
                        <form class="expenses_edit2" id="expenses_edit2" action="{{url('expense/edit')}}" method="post" enctype="multipart/form-data">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--ajax come modal-->

    </div>

    <script type="text/javascript">

        var id = null;
        var from = null;
        var to = null;

        $(document).ready(function () {
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
        });

        $(document).ready(function(){
        $('#date').flatpickr({
            mode: "range",
            onChange: function(selectedDates, dateStr, instance) {
                from = formatDate(selectedDates[0]);
                to = formatDate(selectedDates[1]);
            },
        });
    });

    function searchExpensePage() {
            let search = $('#search').val();
            
            // console.log(date);
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,
                from: from,
                to: to,

            };
            console.log(data);

            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "/expense/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let date = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++) {

                            if(results.data[index].date != null && results.data[index].date != ''){
                                time = results.data[index].date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2]+" "+date.toDateString().split(' ')[1]+", "+date.toDateString().split(' ')[3]
                            }
                            else{
                                date = '-';
                            }
                            html += `<tr>
                                        <td> ${ date  } </td>
                                        <td> ${results.data[index].employee.firstname+' '+results.data[index].employee.lastname} </td>
                                        <td> ${results.data[index].description} </td>
                                        <td> ${results.data[index].total} </td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="expence_approve('${results.data[index].id}')"><i class="fa fa-check-circle" title="Approved"></i></a>
                                            <a href="javascript:void(0)" title="Reject!" onclick="expence_reject('${results.data[index].id}')"><i class="fa fa-ban"></i></a>
                                        </td>
                                        <td class="action-box">
                                            <a href="javascript:void(0);" onclick="OpenEditMileageModel('${results.data[index].id}') ">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${results.data[index].id}')">DELETE</a>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>`;
                        }
                        $('#expense_search').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
        window.onload = function () {
            searchExpensePage()
        };

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
                        url: "/expense/destroy/" + id,
                        data: {_token: '{{  @csrf_token() }}'},
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
