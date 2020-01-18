@extends('layouts.main')
@include('modal')
@section('content1')


    <div class="container-fluid">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-md-10">
                    <div class="row">
                    <div class="col-md-2">
                        <div class="text_outer">
                            <input type="text" placeholder="search" class="form-control" name="search" id="search">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="row margin-top-20">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12"> 
                                    <button type="button" id="search" onclick="searchCompanyPage()" class="btn-dark contact_btn" data-form="expences" style="text-align: center;margin: 0 81px;padding: 2px 46px 8px;font-size: 13px;">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                    <span><i class="fa fa-plus" data-toggle="modal" data-target="#expense-modal" style="background-color:#cecece; font-size:11px; padding:5px; border-radius:50%;color:#fff; float:right;"></i></span>
               

                <div id="pending_div">
                    <table style="width:100%;">
                        <thead>
                        <tr>
                           
                            @admin
                            <th>Company Name</th>
                            @endadmin
                            <th>Logo</th>
                            <th>Email</th>
                            @admin
                            <th>Action</th>
                            @endadmin
                            <th></th>
                        </tr>
                        </thead>
                        <tbody class="return_expence_ajax" id="company_search">
                        
                        <tbody>
                    </table>
                </div>
            </div>
        </div><!-------------end--------->

    </div>



    <div id="expense-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <form id="createCompanyForm">
                    
                        <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company Name</label>
                                        <input type="text" placeholder="" class="form-control" name="companyname" id="companyname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company Email</label>
                                        <input type="email" placeholder="" class="form-control" name="email" id="email">
                                    </div>
                                </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control">
                                </div>
                            </div>  
                        </div>
                    
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <button type="button" id="create" onclick="create_company(event)" class="btn-dark contact_btn" data-form="expences">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Company Reports</span>

                                    </div>
                                </div>
                            </div> 
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="expense-modal-edit2" class="modal fade bs-example-modal-lg expense-modal-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- body modal -->
                <div class="modal-body">
                    <form id="editCompanyForm">
                        <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company Name</label>
                                        <input type="text" placeholder="" class="form-control" name="companyname" id="edit_companyname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company Email</label>
                                        <input type="email" placeholder="" class="form-control" name="email" id="edit_email">
                                    </div>
                                </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6">
                                <div class="text_outer">
                                    <label for="name" class="">Logo</label>
                                    <img src="" id="edit_logo_show" alt="">
                                    <input type="file" name="logo" id="edit_logo" class="form-control">
                                </div>
                            </div>  
                        </div>
                    
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                       
                                        <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                        <button type="button" id="update" onclick="update_company({{ auth()->user()->id }})" class="btn-dark contact_btn" data-form="expences">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Company Reports</span>

                                    </div>
                                </div>
                            </div> 
                    </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    </div>

    <script type="text/javascript">
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

        function create_company(event){
            event.preventDefault();
            $('#create').attr('disabled','disabled');
            var companyname = $('#companyname').val();
            var email = $('#email').val();
            var logo = $('#logo').val();
        //    alert();
            var data = new FormData(document.getElementById('createCompanyForm'));
            // console.log(data)
            if(companyname == '' || email == ''|| logo == ''){
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
                url: "/company/store", //resource route
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function( response ) {
                    $.toaster({ message : 'Created successfully', title : 'Success', priority : 'success' });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }

            });
        }

        var id = null

        function OpenEditCompanyModel(id){
            console.log(id)
            $('#expense-modal-edit2').modal();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: 'GET',
                url: "company/edit/"+id,
                // url: "company/edit"+id,
                dataType: 'JSON',
                success: function (results) {

                    if (results.status === 'success') {
                        $('#edit_companyname').val(results.data.companyname);
                        $('#edit_email').val(results.data.email);
                        $('#edit_logo_show').attr('src','public/logo/'+results.data.logo);
                        $('#update').attr('onclick', 'update_company(' + id + ')');
                        // $('#send_form').attr('onclick','update_cost('+id+')');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function update_company(id){
            // $('#send_form').attr('disabled','disabled');
            var companyname = $('#edit_companyname').val();
            var email = $('#edit_email').val();
            var logo = $('#edit_logo').val();
            
            var data = new FormData(document.getElementById('editCompanyForm'));

            // if(companyname == '' || email == ''|| logo == ''){

            //     // $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' }, 1000);
            //     // $('#send_form').removeAttr('disabled')
            //         alert();

            //     // return false;
            // }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            $.ajax({
                method: "POST",
                url: "company/update/"+id, //resource route
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function( response ) {
                    $.toaster({ message : 'Updated successfully', title : 'Success', priority : 'success' });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }

            });
        }


        function searchCompanyPage() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': "{{csrf_token()}}"
                }
            });
            let search = $('#search').val();
            
            let data = {
                _token: '{{  @csrf_token() }}',
                search: search,
                
            };

            // $('#wait').css('display', 'block'); // wait for loader

            console.log(data);
            $.ajax({
                type: 'post',
                url: "/company/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';

                    if (results.status === 'success') {
                        // $('#wait').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++ ){
                           

                            html += `<tr style="margin-bottom:10px;">
                                        <td> ${results.data[index].companyname } </td>
                                        <td> ${results.data[index].logo } </td>
                                        <td> ${results.data[index].email } </td>
                                        
                                        <td class="action-box"><a href="javascript:void(0);" onclick="OpenEditCompanyModel('${results.data[index].id}')">EDIT</a>
                                        <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${results.data[index].id}')">DELETE</a></td>
                                        </td>
                                        
                                    </tr>`
                        }
                        $('#company_search').html(html);
                     
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }
        window.onload = function(){
            searchCompanyPage()
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
                        type: 'DELETE',
                        url: "/company" + id,
                        data: {_token: '{{  @csrf_token() }}' },
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

    </script>

@endsection
