<div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Subject</label>
                                        <input type="text" id="name" name="subject" class="form-control" value="<?= $maintanance->subject ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Website</label>
                                        <select class="select_status form-control" name="website">
                                            <option value="<?= $maintanance->website ?>"><?= $maintanance->website ?></option>
                                            <option value="Website1">Website1</option>
                                            <option value="Website2">Website2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    A brief description of your ticket
                                    <div class="text_outer">
                                        <label for="name" class="">Description</label>
                                        <input type="text" id="name" name="description" class="form-control" value="<?= $maintanance->description ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Priority</label>
                                        <select class="select_status form-control" name="priority">
                                            <option value="<?= $maintanance->priority ?>"><?= $maintanance->priority ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Category</label>
                                        <select class="select_status form-control" name="category">
                                            <option value="<?= $maintanance->category ?>"><?= $categorya1->categoryname ?></option>
                                            <?php foreach ($category as $category_ex_report) { ?>
                                                <option value="<?= $category_ex_report->id ?>"><?= $category_ex_report->categoryname ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                        <input type="hidden" name="id" value="<?= $maintanance->id ?>">
                                        <input type="hidden" name="emp_id" value="<?= auth()->user()->id; ?>">
                                        <input type="hidden" name="updated_at" value="<?= now(); ?>">
                                        <button type="submit" class="btn-dark contact_btn">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Maintenance</span>
                                    </div>
                                </div>
                            </div>