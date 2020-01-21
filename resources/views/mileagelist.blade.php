@extends('layouts.main')
@include('modal')
@section('content1')


<div class="well-default-trans">
    <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
        <div class="mileage inner-tab-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="date" name="date" id="date"  placeholder="Select Date" class="form-control-new" onChange="searchMileagePage()">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" placeholder="Search employee" onkeyup="searchMileagePage()" class="form-control-new" name="search" id="search">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal" data-target="#mileage-modal"> <i class="fa fa-plus"></i> </a>
                    </div>
                    <div class="col-sm-12">
                        <div id="wait" style="display:none;position:absolute;top:100%;left:50%;padding:2px;"><img src='{{ asset('img/demo_wait.gif') }}' width="64" height="64" /><br>Loading..</div>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Reason for mileage</th>
                                <th>Total Km</th>
                                <th width="200px" class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody class="return_mileagelist" id="mileage_search">
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

    <!----- Mileage Modal add ---->
    <div id="mileage-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form id="employee_mileage">

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company</label>
                                        <select class="select_status form-control" name="companyname" id="companyname">
                                            <option>Select</option>
                                            @foreach($companies as $company)
                                                <option value="{{$company->companyname}}">{{$company->companyname}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Date</label>
                                        <input type="date" placeholder="" name="date" class="form-control" id="date">
                                    </div>


                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Vehicle</label>
                                        <input type="text" id="vehicle" name="vehicle" class="form-control" placeholder="Insert text here">
                                    </div>


                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">No of kilometers</label>
                                        <input type="number" id="kilometers" name="kilometers" class="form-control" placeholder="Insert figure here">
                                    </div>


                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="text_outer">
                                        <label for="name" class="">Reason for mileage</label>
                                        <input type="text" id="reasonformileage" name="reasonformileage" class="form-control" placeholder="Insert text here">
                                    </div>
                                </div>

                            </div>
                            </hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="button" onclick="addmileage_details();" class="btn-dark contact_btn">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Mileage</span>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!--- Mileage modal end -->


    <!----- Mileage Modal edit ---->
    <div id="mileage-modaledit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Company</label>
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
                                    <label for="name" class="">Date</label>
                                    <input type="date" placeholder="" name="date" class="form-control" id="edit_date">
                                </div>


                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Vehicle</label>
                                    <input type="text" id="edit_vehicle" name="vehicle" class="form-control" placeholder="Insert text here">
                                </div>


                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">No of kilometers</label>
                                    <input type="number" id="edit_kilometers" name="kilometers" class="form-control" placeholder="Insert figure here">
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="text_outer">
                                    <label for="name" class="">Reason for mileage</label>
                                    <input type="text" id="edit_reasonformileage" name="reasonformileage" class="form-control" placeholder="Insert text here">
                                </div>
                            </div>

                        </div>
                        </hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    {{-- <button type="button" id="update" onclick="update_mileage({{ $mileage->id }})" class="btn-dark contact_btn" data-form="expences">Save </button> --}}
                                    <button type="button" id="update" onclick="update_mileage(id)" class="btn-dark contact_btn" data-form="expences">Save </button>
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

        var id = null;
        var from = null;
        var to = null;
        function OpenEditMileageModel(id) {
            console.log(id)
            $('#mileage-modaledit').modal();
            $.ajax({
                type: 'GET',
                url: "/mileage/edit/"+id,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        let company = '';
                        let selecteds = '';
                        for (let i = 0; i < results.data.companies.length; i++){
                            if (results.data.companies[i].id === results.data.mileage.company){
                                selecteds = 'selected';
                            }
                            company += ` <option value="${ results.data.companies[i].id }" ${ selecteds }>${ results.data.companies[i].companyname }</option>`;
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
            $('#update').attr('disabled','disabled');
            var company = $('#edit_companyname').val();
            var date = $('#edit_date').val();
            var vehicle = $('#edit_vehicle').val();
            var kilometers = $('#edit_kilometers').val();
            var reasonmileage = $('#edit_reasonformileage').val();
            var data = {
                company:company,
                date:date,
                vehicle:vehicle,
                kilometers:kilometers,
                reasonmileage:reasonmileage,

            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "POST",
                url: "/mileage/update/"+id,
                data: data,
                dataType: 'JSON',
                success: function( response ) {
                    $.toaster({ message : 'Updated successfully', title : 'Success', priority : 'success' });
                    searchMileagePage();
                    $('#mileage-modaledit').modal('hide');
                    $('#update').removeAttr('disabled');
                }

            });
        }



    $(document).ready(function(){
        $('#date').flatpickr({
            mode: "range",
            onChange: function(selectedDates, dateStr, instance) {
                from = formatDate(selectedDates[0]);
                to = formatDate(selectedDates[1]);
            },
        });
    });

        function searchMileagePage() {
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
                url: "/mileage/search",
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
                                        <td> ${results.data[index].reasonmileage} </td>
                                        <td> ${results.data[index].kilometers} </td>
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="OpenEditMileageModel('${results.data[index].id}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${results.data[index].id}')">DELETE</a></td>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;
                        }
                        $('#mileage_search').html(html);
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
        window.onload = function () {
            searchMileagePage()
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
                        url: "/mileage/destroy/" + id,
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
