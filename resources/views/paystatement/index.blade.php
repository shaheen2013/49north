@extends('layouts.main')
@section('content1')

 <div class="container-fluid">
   <div class="tab-pane " id="nav-statements" aria-labelledby="nav-statements-tab">
                        <div class="agreements">
                            <h3><span  class="active-span" id="active_contracts_span">Paystatement  </span></h3>

                            <div id="active_contracts_div">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="date" name="date" id="date" placeholder="Select Date"
                                               class="form-control-new" onChange="searchPayStatementsPage()">
                                    </div>
                                </div>
                                <div class="col-sm-12">

                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Emp id</th>
                                            <th>Date</th>
                                            <th>Descripon</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody class="return_expence_ajax" id="payments_search">

                                            @if($user_list)
                            	@foreach($user_list as $plist)
                                <div class="download_file">
                                    <div class="left_part">
                                    	<p>{{$plist->empid}}</p>
                                        <p>{{$plist->date}}</p>
                                        <p>{{$plist->description}}</p>
                                    </div>
                                    <div class="right_part">
                                    	@if($plist->pdfname)
                                        <a href="{{asset('paystatement/'.$plist->pdfname)}}" target="_blank">VIEW</a>
                                        @else
                                        <a href="#" onclick="paystatement_modal('{{$plist->empid}}')" >UPLOAD</a>

                                        @endif
                                    </div>
                                </div>
                              @endforeach
                            @endif
                
                
                                        </tbody>
                                    </table>

                                </div>
                              
                            </div>

                        </div>
                      </div>


<div id="show_modal_paystatement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form  action="{{url('paystatement/add')}}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                    <input type="file"  name="pdfname" class="form-control" id="pdfname" style="height: 30px;" required>
                                </div>
                            </div>
                        </div>
                        </hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    <button type="submit"  class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Paystatement</span>
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
    function searchPayStatementsPage() {
       
        let data = {
            _token: '{{  @csrf_token() }}',
            from: from,
            to: to,

        };
        console.log(data);
        $('#wait').css('display', 'inline-block'); // wait for loader
        $.ajax({
                type: 'post',
                url: "/paystatement/search",
                data: data,
                dataType: 'JSON',
                success: function (results) {
                    let html = '';
                    let date = '';
                    let pdfname = '';
                    if (results.status === 'success') {
                        $('#wait').css('display', 'none');
                        for (let index = 0; index < results.data.length; index++) {

                            if (results.data[index].date != null && results.data[index].date != '') {
                                time = results.data[index].date.split(' ')[0];
                                date = new Date(time);
                                date = date.toDateString().split(' ')[2] + " " + date.toDateString().split(' ')[1] + ", " + date.toDateString().split(' ')[3]
                            } else {
                                date = 'view';
                            }
                            if (results.data[index].pdfname) {
                                // pdfname ='-' ;
                                pdfname = results.data[index].pdfname != '' ? `<a href="{{url('/')}}/paystatement/${results.data[index].pdfname}" target="_blank">VIEW</a>` : `<a href="#" onclick="paystatement_modal('${results.data[index].emp_id}')">UPLOAD</a>`;
                            } 
                            
                            html += `<tr>

                                    <td> ${results.data[index].emp_id} </td>
                                    <td> ${date} </td>
                                    <td> ${results.data[index].description} </td>
                                    
                                    <td class="action-box">
                                        ${pdfname}
                                    </td>
                                </tr>`;
                        }
                        $('#payments_search').html(html);
                       
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
