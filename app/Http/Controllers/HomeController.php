<?php

namespace App\Http\Controllers;
use App\User;

use App\Employee_detail;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\{Company, Project, Purchases, Categorys, Expenses};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function home()
    {
       
       $emp_id =  auth()->user()->id;
        $data['user'] = DB::table('users as u')
            ->join('employee_details as ed', 'u.id', '=', 'ed.id')
            ->select('ed.*')->where('u.id', '=', $emp_id)
            ->first();
          
       return view('home', $data);
    }

    /**
     * @return Factory|View
     */
    public function employeeRegistration () {
        return view('employee-registration-2');
    }

    /**
     * @param Request $request
     */
    public function expenses(Request $request)
    {
        $data = $request->all();
        Expenses::insert($data);
    }

    /**
     *
     */
    public function expenses_list()
    {
        ob_start();
        if (auth()->user()->user_type == 'is_admin') {
            $expense = Expenses::where(['delete_status' => NULL, 'status' => NULL])->get();
            foreach ($expense as $expense_list) {
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo $expense_list->date ?></td>
                    <td><?php echo $expense_list->description ?></td>
                    <td><?php echo $expense_list->total ?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="expense_approve(<?= $expense_list->id ?>)"><i
                                class="fa fa-check-circle" title="Approved"></i></a>
                        <a href="javascript:void(0)" title="Reject!" onclick="expense_reject(<?= $expense_list->id ?>)"><i
                                class="fa fa-ban"></i></a>
                    </td>
                    <td class="action-box"><a href="javascript:void(0);"
                                              onclick="edit_view_ajax(<?= $expense_list->id ?>)">EDIT</a><a
                            href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        } else {
            $expense = Expenses::where(['emp_id' => auth()->user()->id, 'delete_status' => NULL, 'status' => NULL])->get();
            foreach ($expense as $expense_list) {
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo $expense_list->date ?></td>
                    <td><?php echo $expense_list->description ?></td>
                    <td><?php echo $expense_list->total ?></td>
                    <td class="action-box"><a href="javascript:void(0);"
                                              onclick="edit_view_ajax(<?= $expense_list->id ?>)">EDIT</a><a
                            href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }

        echo json_encode(array(
            "data" => $data,
        ));
    }

    /**
     * @param Request $request
     */
    public function edit_view_expenses(Request $request)
    {
        ob_start();
        $expense = DB::table('expenses')->where('id', $request->id)->first();
        $companies = Company::all();
        $project = Project::all();
        $purchases = Purchases::all();
        $category = Categorys::all();
        $company = DB::table('companies')->where('id', $expense->company)->first();
        $projects = DB::table('projects')->where('id', $expense->project)->first();
        $purchase = DB::table('purchases')->where('id', $expense->purchase)->first();
        $category1 = DB::table('categorys')->where('id', $expense->category)->first();
        ?>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top:40px;margin-bottom:20px;">
                        <form class="expenses_edit1" id="expenses_edit1" action="#">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Company</label>
                                        <select class="select_status form-control" name="company">
                                            <option value="<?= $company->id; ?>"><?= $company->companyname; ?></option>
                                            <?php foreach ($companies as $company_ex_report) { ?>
                                                <option
                                                    value="<?= $company_ex_report->id ?>"><?= $company_ex_report->companyname ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Date</label>
                                        <input type="date" placeholder="" value="<?= $expense->date; ?>"
                                               class="form-control" name="date">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Category</label>
                                        <select class="select_status form-control" name="category">
                                            <option
                                                value="<?= $category1->id ?>"><?= $category1->categoryname ?></option>
                                            <?php foreach ($category as $category_ex_report) { ?>
                                                <option
                                                    value="<?= $category_ex_report->id ?>"><?= $category_ex_report->categoryname ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Purchase via</label>
                                        <select class="select_status form-control" name="purchase">
                                            <option value="<?= $purchase->id ?>"><?= $purchase->purchasename ?></option>
                                            <?php foreach ($purchases as $purchases_ex_report) { ?>
                                                <option
                                                    value="<?= $purchases_ex_report->id ?>"><?= $purchases_ex_report->purchasename ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Project</label>
                                        <select class="select_status form-control" name="project">
                                            <option value="<?= $projects->id ?>"><?= $projects->projectname ?></option>
                                            <?php foreach ($project as $project_ex_report) { ?>
                                                <option
                                                    value="<?= $project_ex_report->id ?>"><?= $project_ex_report->projectname ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Select Receipt</label>
                                        <select class="select_status form-control" name="receipt">
                                            <option value="<?= $expense->receipt ?>"><?= $expense->receipt ?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Description</label>
                                        <input type="text" id="name" name="description" class="form-control"
                                               value="<?= $expense->description ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="col-md-12 col-sm-12">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox"
                                                   name="billable" <?php if ($expense->billable == "on") {
                                                echo "checked";
                                            } ?>> Billable
                                        </label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="display:inline-flex;">
                                            <div class="col-md-7 col-sm-7">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name=""> Received
                                                    authorization
                                                </label>
                                            </div>
                                            <div class="col-md-5 col-sm-5">
                                                <input type="text" id="name" name="received_auth" class="form-control"
                                                       vale="<?= $expense->received_auth; ?>"
                                                       style="border:0px; border-bottom:1px solid;padding: 0px;background-color: #fff !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Subtotal</label>
                                        <input type="text" id="name" name="subtotal" class="form-control"
                                               value="<?= $expense->subtotal ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">GST</label>
                                        <input type="text" id="name" name="gst" class="form-control"
                                               value="<?= $expense->gst ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">PST</label>
                                        <input type="text" id="name" name="pst" class="form-control"
                                               value="<?= $expense->pst ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text_outer">
                                        <label for="name" class="">Total</label>
                                        <input type="text" id="name" name="total" class="form-control"
                                               value="<?= $expense->total ?>">
                                    </div>
                                </div>
                            </div>
                            </hr>
                            <div class="row margin-top-30">
                                <div class="form-group" style="width:100%;">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                        <input type="hidden" name="emp_id" value="<?= auth()->user()->id ?>">
                                        <input type="hidden" name="id" value="<?= $expense->id ?>">
                                        <input type="button" class="btn-dark contact_btn" onclick="edit_expenses()"
                                               value="Save">
                                        <span class="close close-span" data-dismiss="modal" aria-label="Close"><i
                                                class="fa fa-arrow-left"></i> Return to Expense Reports</span>
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
        echo json_encode(array(
            "data" => $data,
        ));
    }

    /**
     * @param Request $request
     */
    public function expenses_edit(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        Expenses::where('id', $id)->update($data);
    }

    /**
     * @param Request $request
     */
    public function delete_expense(Request $request)
    {
        $id = $request->id;
        Expenses::where('id', $id)->update(['delete_status' => '1']);
    }

    /**
     * @param Request $request
     */
    public function expense_approve(Request $request)
    {
        $id = $request->id;
        Expenses::where('id', $id)->update(['status' => '1']);
    }

    /**
     * @param Request $request
     */
    public function expense_reject(Request $request)
    {
        $id = $request->id;
        Expenses::where('id', $id)->update(['status' => '2']);
    }

    /**
     *
     */
    public function expenses_historical()
    {
        ob_start();
        if (auth()->user()->user_type == 'is_admin') {
            $expense = Expenses::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
            foreach ($expense as $expense_list) {
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo $expense_list->date ?></td>
                    <td><?php echo $expense_list->description ?></td>
                    <td><?php echo $expense_list->total ?></td>
                    <td class="action-box">
                        <!--<a href="javascript:void(0);" onclick="edit_view_ajax(<?= $expense_list->id ?>)" >EDIT</a>--><a
                            href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        } else {
            $expense = Expenses::where(['emp_id' => auth()->user()->id, 'delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
            foreach ($expense as $expense_list) {
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo $expense_list->date ?></td>
                    <td><?php echo $expense_list->description ?></td>
                    <td><?php echo $expense_list->total ?></td>
                    <td class="action-box">
                        <!--<a href="javascript:void(0);" onclick="edit_view_ajax(<?= $expense_list->id ?>)" >EDIT</a>--><a
                            href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }

        echo json_encode(array(
            "data" => $data,
        ));

    }

    /**
     * @return Factory|View
     */
    public function agreement_list()
    {
        $employee = DB::table('employee_details as ed')
            ->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')
            ->leftjoin('codeofconduct as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement')
            //->where(array('a.status'=>'A','coc.status'=>'A'))
            ->get();
        return view('admin.agreement_list')->with('employee', $employee);

    }

    function add_empagreement(Request $request)
    {
        if ($request->hasFile('agreement_file')) {
            $file = $request->file('agreement_file');
            $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
        }
        $conditions = array('emp_id' => $request->employee_id);
        if ($request->agreement_type == 'EA') {
            $request->file('agreement_file')->move("public/agreement", $name);
            $agreement_details = DB::table('agreements')->where($conditions)->first();
            if ($agreement_details) {
                DB::table('agreements')->where($conditions)->update(
                    ['emp_id' => $request->employee_id,
                        'agreement' => $name,
                        'old_agreement' => $agreement_details->agreement,
                    ]);
            } else {
                DB::table('agreements')->insert(
                    ['emp_id' => $request->employee_id,
                        'agreement' => $name,
                        'old_agreement' => $name,
                    ]
                );
            }


        } else {
            $request->file('agreement_file')->move("public/codeofconduct", $name);
            $agreement_details = DB::table('codeofconduct')->where($conditions)->first();
            if ($agreement_details) {
                DB::table('codeofconduct')->where($conditions)->update(
                    ['emp_id' => $request->employee_id,
                        'coc_agreement' => $name,
                        'old_coc' => $agreement_details->coc_agreement,
                    ]);
            } else {
                DB::table('codeofconduct')->insert(
                    ['emp_id' => $request->employee_id,
                        'coc_agreement' => $name,
                        'old_coc' => '',
                    ]
                );
            }
        }
    }


    function destroy($id, $type)
    {
        if ($type == 'EA') $queries = DB::table('agreements')->update('emp_id', '=', $id)->delete(['status' => 'D']);
        if ($type == 'COC') $queries = DB::table('codeofconduct')->where('emp_id', '=', $id)->update(['status' => 'D']);

        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);

    }

    function employee_agreementlist()
    {
        $employee = DB::table('employee_details as ed')
            ->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')
            ->leftjoin('codeofconduct as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement')
            ->where(array('ed.id' => auth()->user()->emp_id))
            ->get();
        return view('agreement_listnew')->with('employee', $employee);
    }


    public function benefits () {
        return view('benefits');
    }

    public function edit_employee(Request $request)
    {
        $id = $request->input('id');

        //Validate name, email and password fields
        $rules = [
            'firstname' => 'required|max:120',
            'lastname' => 'required|max:120',
            'email' => Rule::unique('users')->ignore($id) // require unique email address
        ];

        // morph input fields to match user table
        $input['name'] = $request->input('firstname') . ' ' . $request->input('lastname');
        $input['email'] = $request->input('workemail');

        // if password is entered or it's a new user
        if ($request->input('password') || !$id) {
            //$rules['password'] = 'required|min:6|confirmed';
            $rules['password'] = ['required', 'string', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'];
            $input['password'] = Hash::make($request->input('password'));
        }

        $this->validate($request, $rules);

        // check for admin details
        $input['is_admin'] = $request->input('is_admin', 0);

        //profile pic  code
        $profilepicname = '';
        if ($request->hasFile('profile_pic')) {

            $file = $request->file('profile_pic');
            $profilepicname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('profile_pic')->move("public/profile");
        }
        /// end profile pic

        // employee details array start
        $user_array = $request->only(['firstname','lastname','dob','personalemail','phone_no','address','workemail','profile_pic','marital_status','no_ofchildren','family_inarea','spcifamilycircumstace','prsnl_belief','known_medical_conditions','allergies','dietary_restrictions','known_health_concerns','aversion_phyactivity','emergency_contact_name','reltn_emergency_contact','emergency_contact_phone','emergency_contact_email']);
        $user_array['profile_pic'] = $profilepicname;

        if ($id) {
            $user = User::find($id);
            $user->update($input);
            $emp_id = $id;
/*            $user_detailsupdate = Employee_detail::find($id);
            $user_detailsupdate->update($user_array);*/
            $msg = 'User successfully updated';
        } else {
            $user = User::create($input);
           
            $msg = 'User successfully Added';
        }

        if (isset($emp_id)) {
            //$user->employee_details()->update($user_array);
            Employee_detail::where('id','=',$emp_id)->update($user_array);
        }
        else {
            $user->employee_details()->create($user_array);
          
        }

        //Redirect to the users.index view and display message
        return redirect()->route('home')
            ->with('flash_message', $msg);
    }



///////////  Agreement List 

     function agreementlist()
    {
        $employee = DB::table('employee_details as ed')
            ->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')
            ->leftjoin('codeofconduct as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement')
            ->where(array('ed.id' => auth()->user()->emp_id))
            ->get();
        return view('agreement_listnew')->with('agreement', $employee);
    }







}
