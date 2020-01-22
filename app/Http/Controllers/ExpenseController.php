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

  

   //search history
    public function searchHistory(Request $request){
      
        $data = Expenses::orderByDesc('created_at')->with('employee:id,firstname,lastname')->where('status', '!=', null)
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

    //search pending

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

    //expense destroy
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
       
    }

}
