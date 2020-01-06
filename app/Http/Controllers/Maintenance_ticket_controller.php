<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Project;
use App\Purchases;
use App\Categorys;
use App\expenses;
use App\Maintenance_ticket;
use App\Employee_detail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

class Maintenance_ticket_controller extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     */
    public function index (Request $request) {
        $data = $request->all();
        Maintenance_ticket::insert($data);
    }

    /**
     *
     */
    public function maintanance_list () {
        ob_start();
        if (auth()->user()->user_type == 'is_admin') {
            $maintanance = Maintenance_ticket::where(['delete_status' => NULL, 'status' => NULL])->get();
            foreach ($maintanance as $maintanance_list) {
                $emprec = DB::table('employee_details')->where(['id' => $maintanance_list->emp_id])->first();
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo "#00" . $maintanance_list->id ?></td>
                    <td><?php echo $maintanance_list->subject ?></td>
                    <td><?php
                        if ($maintanance_list->status == NULL) {
                            echo "Pending";
                        }
                        elseif ($maintanance_list->status == 1) {
                            echo "in progress";
                        }
                        elseif ($maintanance_list->status == 2) {
                            echo "Close";
                        }
                        ?></td>
                    <td><?php echo $maintanance_list->updated_at ?></td>
                    <td><?php echo $emprec->firstname . ' ' . $emprec->lastname; ?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="ticket_inprogress(<?= $maintanance_list->id ?>)"><i class="fa fa-check-circle" title="In Progress"></i></a>
                        <a href="javascript:void(0)" title="Cancel!" onclick="ticket_cancel(<?= $maintanance_list->id ?>)"><i class="fa fa-ban"></i></a>
                    </td>

                    <td class="action-box">
                        <a href="javascript:void(0);" onclick="mainance_edit_view_ajax(<?= $maintanance_list->id ?>)">EDIT</a><a href="javascript:void(0);" class="down" onclick="delete_maintance(<?= $maintanance_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }
        else {
            $maintanance = Maintenance_ticket::where(['emp_id' => auth()->user()->id, 'delete_status' => NULL, 'status' => NULL])->get();
            foreach ($maintanance as $maintanance_list) {
                $emprec = DB::table('employee_details')->where(['id' => $maintanance_list->emp_id])->first();
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo "#00" . $maintanance_list->id; ?></td>
                    <td><?php echo $maintanance_list->subject; ?></td>
                    <td><?php
                        if ($maintanance_list->status == NULL) {
                            echo "Pending";
                        }
                        elseif ($maintanance_list->status == 1) {
                            echo "in progress";
                        }
                        elseif ($maintanance_list->status == 2) {
                            echo "Close";
                        }
                        ?></td>
                    <td><?php echo $maintanance_list->updated_at; ?></td>
                    <td><?php echo $emprec->firstname . ' ' . $emprec->lastname; ?></td>
                    <td class="action-box">
                        <a href="javascript:void(0);" onclick="mainance_edit_view_ajax(<?= $maintanance_list->id ?>)">EDIT</a><a href="javascript:void(0);" class="down" onclick="delete_maintance(<?= $maintanance_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }

        echo json_encode([
            "data" => $data,
        ]);
    }

    /**
     * @param Request $request
     */
    public function mainance_edit_view_ajax (Request $request) {
        ob_start();
        $maintanance = DB::table('maintenance_tickets')->where('id', $request->id)->first();
        $category = Categorys::all();
        $categorya1 = Categorys::where('id', $maintanance->category)->first();
        ?>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="maintenance1_edit" action="" method="POST">
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
                                        <button type="button" class="btn-dark contact_btn" onclick="maintenance1_edit(this.value)">Save</button>
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i class="fa fa-arrow-left"></i> Return to Maintenance</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $data = ob_get_clean();
        echo json_encode([
            "data" => $data,
        ]);
    }

    /**
     * @param Request $request
     */
    public function maintenance1_edit (Request $request) {
        $id = $request->id;
        $data = $request->all();
        $try = Maintenance_ticket::where(['id' => $id])->update($data);
    }

    /**
     * @param Request $request
     */
    public function delete_maintance (Request $request) {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['delete_status' => 1]);
    }

    /**
     * @param Request $request
     */
    public function ticket_inprogress (Request $request) {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['status' => 1]);
    }

    /**
     * @param Request $request
     */
    public function ticket_cancel (Request $request) {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['status' => 2]);
    }

    /**
     *
     */
    public function complited_ticket () {
        ob_start();
        if (auth()->user()->user_type == 'is_admin') {
            $maintanance = Maintenance_ticket::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
            foreach ($maintanance as $maintanance_list) {
                $emprec = DB::table('employee_details')->where(['id' => $maintanance_list->emp_id])->first();
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo "#00" . $maintanance_list->id ?></td>
                    <td><?php echo $maintanance_list->subject ?></td>
                    <td><?php
                        if ($maintanance_list->status == NULL) {
                            echo "Pending";
                        }
                        elseif ($maintanance_list->status == 1) {
                            echo "in progress";
                        }
                        elseif ($maintanance_list->status == 2) {
                            echo "Close";
                        }
                        ?></td>
                    <td><?php echo $maintanance_list->updated_at ?></td>
                    <td><?php echo $emprec->firstname . ' ' . $emprec->lastname; ?></td>
                    <td>
                        <a href="javascript:void(0)">View</a>
                    </td>

                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }
        else {
            $maintanance = Maintenance_ticket::where(['emp_id' => auth()->user()->id, 'delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
            foreach ($maintanance as $maintanance_list) {
                $emprec = DB::table('employee_details')->where(['id' => $maintanance_list->emp_id])->first();
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo "#00" . $maintanance_list->id; ?></td>
                    <td><?php echo $maintanance_list->subject; ?></td>
                    <td><?php
                        if ($maintanance_list->status == NULL) {
                            echo "Pending";
                        }
                        elseif ($maintanance_list->status == 1) {
                            echo "in progress";
                        }
                        elseif ($maintanance_list->status == 2) {
                            echo "Close";
                        }
                        ?></td>
                    <td><?php echo $maintanance_list->updated_at; ?></td>
                    <td><?php echo $emprec->firstname . ' ' . $emprec->lastname; ?></td>
                    <td class="action-box"><a href="javascript:void(0)">View</a></td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }

        echo json_encode([
            "data" => $data,
        ]);

    }

}


