<div id="upload-modal1" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form id="" action="{{ route('reset_apssword') }}" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text_outer file_upload" style="height: 60px;">
                                    <label for="name" class="">Password</label>
                                    <input type="text"  name="password" class="form-control"  style="height: 30px;" maxlength="6" required>
                                </div>
                            </div>
                        </div>
                        </hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">
                                    {{ csrf_field() }}

                                    <button type="submit" class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Reset</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="show_modal_agreement" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                    <form id="upload_agreement" enctype="multipart/form-data">
                     
                        @csrf
                        <input type="hidden"  name="employee_id" id="employee_id_modal">
                        <input type="hidden"  name="agreement_type" id="agreement_type">
                        <div class="row">
                           <!-- <div class="col-md-6">
                                <div class="file_upload" style="height: 60px;">

                                    <label class="containers">Employee Agreement
                                      <input type="radio" checked="checked" name="agtype" value="EA" >
                                      <span class="checkmark"></span>
                                    </label>
                                    <label class="containers">Code of Conduct
                                      <input type="radio" name="agtype" value="COC">
                                      <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>-->
                            <div class="col-md-12">
                                <div class="text_outer file_upload" style="height: 60px;">
                                    <label for="name" class="">Upload Agreement</label>
                                    <input type="file"  name="agreement_file" class="form-control" id="agreement_file" style="height: 30px;" required>
                                </div>
                            </div>
                        </div>
                        </hr>
                        <div class="row margin-top-30">
                            <div class="form-group" style="width:100%;">
                                <div class="col-md-12 col-sm-12">

                                    <button type="submit"  class="btn-dark contact_btn">Save</button>
                                    <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Agreement</span>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
