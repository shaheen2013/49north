@extends('layouts.main')
@include('modal')
@section('content1')

<div class="container-fluid">
    <div class="tab-pane" id="nav-mileage" role="tabpanel" aria-labelledby="nav-mileage-tab">
        <div class="mileage inner-tab-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="text" placeholder="Search Mileage" onkeyup="searchMileagePage()"
                                   class="form-control-new" name="search" id="search">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal"
                           data-target="#mileage-modal">
                            <i class="fa fa-plus"></i>
                        </a>
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
                                @if($mileage_list)
                                {{-- @foreach ($mileage_list as $mlist)
        
                                    <tr style="margin-bottom:10px;">
                                        <td>{{ $mlist->date->format('M d, Y') }}</td>
                                        @admin
                                        <td>{{ $mlist->employee->name }}</td>
                                        @endadmin
        
                                        <td>{{ $mlist->reasonmileage }}</td>
                                        <td>{{ $mlist->kilometers }}</td>
        
                                        <td class="action-box">
                                            <a href="javascript:void();" data-toggle="modal" data-target="#mileage-modaledit" data="{{ $mlist->id }}" class="edit_mileage" onclick="edit_mileage({{ $mlist->id }})">EDIT</a>
                                            <a href="#" class="down" onclick="delete_mileage({{ $mlist->id }});">DELETE</a></td>
                                    </tr>
                                    <tr class="spacer"></tr>
        
                                @endforeach --}}
                            @endif

                            <tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-------------end--------->

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
                                        <input type="date" placeholder="" name="date" class="form-control">
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


    <div id="mileage-modaledit" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form id="employee_mileageedit" action="{{url('updatemileage') }}" method="POST">

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        function searchMileagePage() {
            let search = $('#search').val();
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,

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

                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++) {
                            html += `<tr>
                                        <td> ${results.data[index].date} </td>
                                        <td> ${results.data[index].employee.firstname} </td>
                                        <td> ${results.data[index].reasonmileage} </td>
                                        <td> ${results.data[index].kilometers} </td>
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="OpenEditCompanyModel('${results.data[index].id}')">EDIT</a>
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

    </script>
@endsection
