@extends('layouts.main')
@section('content1')

    <div class="container-fluid">
        <div class="tab-pane " id="nav-statements" aria-labelledby="nav-statements-tab">
            <div class="agreements">
                <h3><span class="active-span" id="active_contracts_span">Paystatement  </span></h3>

                <div id="active_contracts_div">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="date" name="date" id="date" placeholder="Select Date"
                                   class="form-control-new" onChange="searchPayStatementsPage()">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div id="wait"></div>
                    </div>
                    <div class="top_part_">
                        <ul>
                            <li>Emp id</li>
                            <li>Date</li>
                            <li>Descripon</li>
                            <li style="float:right;">Action</li>
                        </ul>
                    </div>
                    @if($user_list)

                        <div id="payments_search">

                        </div>

                    @endif
                   

                </div>
                <div id="paginate"></div>

            </div>
        </div>


        <div id="show_modal_paystatement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-body">
                        <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                            <form id="createPayForm">
                            <input type="hidden" name="emp_id" id="empidstatement">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text_outer">
                                            <label for="name" class="">Description</label>
                                            <input type="text" id="description" name="description" class="form-control" placeholder="Insert text here">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text_outer">
                                            <label for="name" class="">Date</label>
                                            <input type="date" id="date" name="date" class="form-control" placeholder="Insert text here">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text_outer file_upload" style="height: 60px;">
                                            <label for="name" class="">Upload PDF</label>
                                            <input type="file" name="pdfname" class="form-control" id="pdfname" style="height: 30px;" required>
                                        </div>
                                    </div>
                                </div>
                                </hr>
                                <div class="row margin-top-30">
                                    <div class="form-group" style="width:100%;">
                                        <div class="col-md-12 col-sm-12">
                                            <button type="button" id="create" onclick="create_upload(event)" class="btn-dark contact_btn" data-form="expences">Save</button>
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
            $('#date').flatpickr({
                mode: "range",
                onChange: function (selectedDates, dateStr, instance) {
                    from = formatDate(selectedDates[0]);
                    to = formatDate(selectedDates[1]);
                },
            });
        });

        function create_upload(event){
            event.preventDefault();
            $('#create').attr('disabled','disabled');
            var description = $('#description').val();
            var date = $('#date').val();
            var data = new FormData(document.getElementById('createPayForm'));
            
            $.ajax({
                method: "POST",
                url: "/paystatement/store", //resource route
                data: data,
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                success: function( response ) {
                    if (response.status == 'success') {
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
            let data = {
                _token: '{{  @csrf_token() }}',
                from: from,
                to: to,

            };
            $('#wait').css('display', 'inline-block'); // wait for loader
            $.ajax({
                type: 'post',
                url: "/paystatement/search",
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
                                let date = '';
                                let description = '';
                                let pdfname = '';
                        for (let index = 0; index < data.length; index++) {

                            if (data[index].date != null && data[index].date != '') {
                                time = data[index].date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                            } else {
                                date = '-';
                            }

                            if (data[index].description != null && data[index].description != '') {
                                description = data[index].description;
                            } else {
                                description = '-';
                            }

                            if (data[index].description != null && data[index].description != '') {
                                pdfname = `<a href="${data[index].pdfname}" target="_blank">VIEW</a>`;
                            } else {
                                pdfname = `<a href="#" onclick="paystatement_modal('${data[index].empid}')">UPLOAD</a>`
                            }

                            html += `
                            <div class="download_file">
                            <div class="left_part">

                                    <p> ${data[index].empid} </p>
                                    <p> ${date} </p>
                                    <p> ${description} </p>
                                </div>

                                    <div class="right_part">
                                        ${pdfname}
                                    </div>
                                    </div>
                                `;
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

        window.onload = function () {
            searchPayStatementsPage()
        };
    </script>
@endsection
