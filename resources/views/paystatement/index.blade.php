@extends('layouts.main')
@section('content1')
@if(Session::has('paystatement'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('paystatement') }}</p>
@endif
 <div class="container-fluid">
   <div class="tab-pane " id="nav-statements" aria-labelledby="nav-statements-tab">
                        <div class="agreements">
                            <h3><span  class="active-span" id="active_contracts_span">Paystatement  </span></h3>
                            
                            <div id="active_contracts_div">
                                <div class="top_part_">
                                    <ul>
                                    	<li>Emp id</li>
                                        <li>Date</li>
                                        <li>Descripon</li>
                                        <li style="float:right;">Action</li>
                                    </ul>
                                </div>
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
                                </div><!------------------>
                              @endforeach
                            @endif
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

@endsection