@extends('layouts.main')
@include('modal')
@section('content1')
    <div class="well-default-trans">
        <div class="tab-pane" id="nav-expense" role="tabpanel" aria-labelledby="nav-employee-tab">
            <div class="expense inner-tab-box">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="text" placeholder="Search Company" onkeyup="searchCompanyPage()" class="form-control-new" name="search" id="search">
                                <span class="remove-button" onclick="document.getElementById('search').value = '';searchCompanyPage()"><i class="fa fa-times" aria-hidden="true"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div id="wait"></div>
                        </div>
                        <div class="col-sm-9">
                            <a href="javascript:void(0)" class="_new_icon_button_1" data-toggle="modal"
                               data-target="#company-modal">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <div class="col-sm-12">
                            <table class="table _table _table-bordered">
                                <thead>
                                <tr>
                                    <th>Company Logo</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th width="200px" class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tbody class="return_expence_ajax" id="company_search">

                                </tbody>
                            </table>
                            <div id="paginate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="company-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                        <input type="text" placeholder="" class="form-control" name="companyname"
                                               id="companyname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company Email</label>
                                        <input type="email" placeholder="" class="form-control" name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 image-chooser">
                                    <div class="image-chooser-preview"></div>
                                    <div class="text_outer">
                                        <label for="name" class=""><i class="fa fa-fw fa-photo"></i> Click to Choose Logo</label>
                                        <input type="file" onchange="renderChoosedFile(this)" name="logo" id="logo" class="form-control _input_choose_file">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                    <button type="button" id="create" onclick="create_company(event)" class="btn-dark contact_btn" data-form="expences">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Company Reports</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="company-modal-edit2" class="modal fade bs-example-modal-lg company-modal-edit" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                        <input type="text" placeholder="" class="form-control" name="companyname"
                                               id="edit_companyname">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company Email</label>
                                        <input type="email" placeholder="" class="form-control" name="email"
                                               id="edit_email">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 image-chooser">
                                    <div class="image-chooser-preview"></div>
                                    <div class="text_outer">
                                        <label for="name" class=""><i class="fa fa-fw fa-photo"></i> Click to Choose Logo</label>
                                        <img src="" id="edit_logo_show" alt="" width="50" height="50">
                                        <input type="file" onchange="renderChoosedFile(this)" name="logo" id="edit_logo" class="form-control _input_choose_file">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">

                                    <input type="hidden" name="emp_id" value="{{ auth()->user()->id }}">
                                    <button type="button" id="update"
                                            onclick="update_company({{ auth()->user()->id }})"
                                            class="btn-dark contact_btn" data-form="expences">Save
                                    </button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i
                                            class="fa fa-arrow-left"></i> Return to Company Reports</span>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        var id = updateRoute = null;

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

        window.onload = function () {
            searchCompanyPage()
        };

        function create_company(event){
            event.preventDefault();
            $('#create').attr('disabled','disabled');
            var companyname = $('#companyname').val();
            var email = $('#email').val();
            //    alert();
            var data = new FormData(document.getElementById('createCompanyForm'));
            if(companyname === '' || email === ''){
                $.toaster({ message : 'Field is required!', title : 'Required', priority : 'danger' });

                $('#create').removeAttr('disabled');

                return false;
            }
            $.ajax({
                method: "POST",
                url: "{{ route('company.store') }}",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function( response ) {
                    if (response.status == 'success') {
                        $.toaster({message: 'Created successfully', title: 'Success', priority: 'success'});
                        searchCompanyPage();
                        $('#company-modal').modal('hide');
                        $('#create').removeAttr('disabled');
                    } else {
                        $.toaster({message: 'Created failed', title: 'Failed', priority: 'fail'});
                    }
                }
            });
        }

        function OpenEditCompanyModel(id, route, update) {
            updateRoute = update;
            console.log(id)
            $('#company-modal-edit2').modal();
            $.ajax({
                type: 'GET',
                url: route,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#edit_companyname').val(results.data.companyname);
                        $('#edit_email').val(results.data.email);
                        $('#edit_logo_show').attr('src','{{ fileUrl() }}' + results.data.logo);
                        $('#update').attr('onclick', 'update_company(' + id + ')');
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });
        }

        function update_company(id) {
            $('#update').attr('disabled','disabled');
            var companyname = $('#edit_companyname').val();
            var email = $('#edit_email').val();
            var data = new FormData(document.getElementById('editCompanyForm'));
            $.ajax({
                method: "POST",
                url: updateRoute,
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function( response ) {
                    $.toaster({ message : 'Updated successfully', title : 'Success', priority : 'success' });
                    searchCompanyPage();
                    $('#company-modal-edit2').modal('hide');
                    $('#update').removeAttr('disabled');
                }

            });
        }

        function searchCompanyPage() {
            let search = $('#search').val();

            if ($.trim(search).length > 0) {
                $('.remove-button').show();
            } else {
                $('.remove-button').hide();
            }

            let data = {
                search: search,
            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "{{ route('company.search') }}",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        $('#paginate').pagination({
                            dataSource: results.data,
                            pageSize: 10,
                            totalNumber: results.data.length,
                            callback: function(data, pagination) {
                                let html = '';
                                for (let index = 0; index < data.length; index++) {
                                    html += `<tr>
                                        <td> ${data[index].logo !== null ? '<img src={{ fileUrl() }}'+data[index].logo+' height="50px" alt="">' : 'N/A'} </td>
                                        <td> ${data[index].companyname} </td>
                                        <td> ${data[index].email !== null ? data[index].email : 'N/A'} </td>
                                        <td class="text-right">
                                            <a href="javascript:void(0);" onclick="OpenEditCompanyModel('${data[index].id}', '${data[index].routes.edit}', '${data[index].routes.update}')">EDIT</a>
                                            <a href="javascript:void(0);" class="down" onclick="deleteconfirm('${data[index].id}', '${data[index].routes.destroy}')">DELETE</a></td>
                                        </td>
                                    </tr><tr class="spacer"></tr>`;
                                }
                                $('#company_search').html(html);
                            }
                        });
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
                        url: "/company/destroy/" + id,
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Done!", results.message, "success").then(function () {
                                    window.location.reload()
                                });
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
