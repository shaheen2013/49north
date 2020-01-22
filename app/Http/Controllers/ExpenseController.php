<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, Project, Purchases, Categorys, Expenses};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller {

    ///   Add Expenselist
    function expenselist () {
        $data['companies'] = Company::all();
        $data['project'] = Project::all();
        $data['purchases'] = Purchases::all();
        $data['category'] = Categorys::all();
        $data['expense'] = Expenses::where(['delete_status' => NULL, 'status' => NULL])->get();

        return view('expense.expensereport', $data);
    }

    //search expense

    public function searchExpense(Request $request){
      
        $data = Expenses::orderByDesc('created_at')->with('employee:id,firstname,lastname')
            ->where(function ($q) use($request){
                if(isset($request->search)){
                    $q->whereHas('employee', function($sql) use($request){
                        $sql->where('firstname', 'LIKE', '%'.$request->search.'%');
                        $sql->orWhere('lastname', 'LIKE', '%'.$request->search.'%');
        
                    });
                    
                }
                if(isset($request->from) && isset($request->to)){
                    $q->whereBetween('date', [$request->from, $request->to]);
                }
            });

            $data= $data->get();
            return response()->json(['status'=>'success', 'data' => $data]);
       
    }
    
    public function searchHistory(Request $request){
      
        $data = Expenses::orderByDesc('created_at')->with('employee:id,firstname,lastname')->where('status', 1)->orWhere(['status' => 2])
        ->where(function ($q) use($request){
            if(isset($request->history_search)){
                $q->whereHas('employee', function($sql) use($request){
                    $sql->where('firstname', 'LIKE', '%'.$request->history_search.'%');
                    $sql->orWhere('lastname', 'LIKE', '%'.$request->history_search.'%');
    
                });
                
            }
            if(isset($request->history_from) && isset($request->history_to)){
                $q->whereBetween('date', [$request->history_from, $request->history_to]);
            }
        });

        $data= $data->get();
        return response()->json(['status'=>'success', 'data' => $data]);
       
    }

    public function searchPending(Request $request){
      
        $data = Expenses::orderByDesc('created_at')->with('employee:id,firstname,lastname')->where('status', null)
        ->where(function ($q) use($request){
            if(isset($request->pending_search)){
                $q->whereHas('employee', function($sql) use($request){
                    $sql->where('firstname', 'LIKE', '%'.$request->pending_search.'%');
                    $sql->orWhere('lastname', 'LIKE', '%'.$request->pending_search.'%');
    
                });
                
            }
            if(isset($request->from) && isset($request->to)){
                $q->whereBetween('date', [$request->from, $request->to]);
            }
        });
        $data= $data->get();   
        return response()->json(['status'=>'success', 'data' => $data]);
       
    }

    //expense edit page with value
    public function edit(Request $request) {
        // $emp_id = auth()->user()->id;
        $data['expense'] = Expenses::where('id', $request->id)->first();
        $data['companies'] = Company::all();
        $data['project'] = Project::all();
        $data['purchases'] = Purchases::all();
        $data['category'] = Categorys::all();
       
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    public function update(Request $request, $id) {
        // Validate form data
        $rules = [
           
            'receipt' => 'nullable|image',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }
        try {// return $request->all();
            $data = Expenses::findOrFail($id);
            $receipt = null;

            if ($request->hasFile('receipt')) {
                Storage::delete($data->receipt);
                $data->receipt = fileUpload('receipt');
            }

            $data->company = $request->company;
            $data->category = $request->category;
            $data->purchase = $request->purchase;
            $data->project = $request->project;
            $data->description = $request->description;
            $data->date = $request->date;
            $data->billable = $request->billable;
            $data->received_auth = $request->received_auth;
            $data->subtotal = $request->subtotal;
            $data->gst = $request->gst;
            $data->pst = $request->pst;
            $data->total = $request->total;

            if ($data->update()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
       
    }
    public function destroy($id) {
        $expense = Expenses::findOrFail($id);
        if ($expense->delete() == 1) {
            $success = true;
            $message = "Expense deleted successfully";
        } else {
            $success = false;
            $message = "Expense not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    ///////  Add Expense
    function addexpense (Request $request) {
        $data = $request->all();
        //receipt code   code
        $receiptname = '';
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $receiptname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('receipt')->move("receipt", $receiptname);
        }

        $data['receipt'] = $receiptname;

        Expenses::insert($data);
        $msg = "Expense added successfully";

        return redirect()->back()->with('alert-info', $msg);
    }

    /// approved expense
    public function approve($id) {
        $data = Expenses::find($id);
        $data->status = 1;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
        // $id = $request->id;
        // Expenses::where('id', $id)->update(['status' => '1']);
    }

    /// expense reject
    public function reject($id) {
        $data = Expenses::find($id);
        $data->status = 2;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
        // $id = $request->id;
        // Expenses::where('id', $id)->update(['status' => '2']);
    }

    ///// expenses history

    public function expenses_historical () {
        ob_start();
        if (auth()->user()->user_type == 'is_admin') {
            $expense = Expenses::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
            foreach ($expense as $expense_list) {
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo $expense_list->date ?></td>
                    <td><?php echo $expense_list->employee->firstname ?></td>
                    <td><?php echo $expense_list->description ?></td>
                    <td><?php echo $expense_list->total ?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="expence_approve(<?= $expense_list->id ?>)"><i class="fa fa-check-circle" title="Approved"></i></a>
                        <a href="javascript:void(0)" title="Reject!" onclick="expence_reject(<?= $expense_list->id ?>)"><i class="fa fa-ban"></i></a>
                    </td>
                    <td class="action-box">
                        <!--<a href="javascript:void(0);" onclick="edit_view_ajax(<?= $expense_list->id ?>)" >EDIT</a>-->
                        <a href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">EDIT</a>
                        <a href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">DELETE</a>
                    </td>
                </tr>
                <tr class="spacer"></tr>
                <?php
            }
            $data = ob_get_clean();
        }
        else {
            $expense = Expenses::where(['emp_id' => auth()->user()->id, 'delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->get();
            foreach ($expense as $expense_list) {
                ?>
                <tr style="margin-bottom:10px;">
                    <td><?php echo $expense_list->date ?></td>
                    <td><?php echo $expense_list->employee->firstname?></td>
                    <td><?php echo $expense_list->description ?></td>
                    <td><?php echo $expense_list->total ?></td>
                    <td>
                        <a href="javascript:void(0)" onclick="expence_approve(<?= $expense_list->id ?>)"><i class="fa fa-check-circle" title="Approved"></i></a>
                        <a href="javascript:void(0)" title="Reject!" onclick="expence_reject(<?= $expense_list->id ?>)"><i class="fa fa-ban"></i></a>
                    </td>
                    <td class="action-box">
                        <!--<a href="javascript:void(0);" onclick="edit_view_ajax(<?= $expense_list->id ?>)" >EDIT</a>-->
                        <a href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">EDIT</a>
                        <a href="javascript:void(0);" class="down" onclick="delete_expense(<?= $expense_list->id ?>)">DELETE</a>
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

}
