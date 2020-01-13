<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, Project, Purchases, Categorys, Expenses};
use Illuminate\Support\Facades\DB;

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

    ///////  Add Expense
    function addexpense (Request $request) {
        $data = $request->all();
        //receipt code   code
        $receiptname = '';
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $receiptname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('receipt')->move("public/receipt", $receiptname);
        }

        $data['receipt'] = $receiptname;

        Expenses::insert($data);
        $msg = "Expense added successfully";

        return redirect()->back()->with('alert-info', $msg);
    }

    /////// Auto populate expense details
    function expense_edit_view (Request $request) {
        $data['expense'] = DB::table('expenses')->where('id', $request->id)->first();
        $data['companies'] = Company::all();
        $data['project'] = Project::all();
        $data['purchases'] = Purchases::all();
        $data['category'] = Categorys::all();
        $data['company'] = DB::table('companies')->where('id', $data['expense']->company)->first();
        $data['projects'] = DB::table('projects')->where('id', $data['expense']->project)->first();
        $data['purchase'] = DB::table('purchases')->where('id', $data['expense']->purchase)->first();
        $data['category1'] = DB::table('categorys')->where('id', $data['expense']->category)->first();

        return view('ajaxview.editexpense', $data);
    }

    ///// To edit details of expense
    public function expenses_edit (Request $request) {
        $data = $request->all();
        $id = $data['id'];

        $receiptname = '';
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $receiptname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('receipt')->move("public/receipt", $receiptname);
        }

        $data['receipt'] = $receiptname;

        Expenses::where('id', $id)->update($data);
        $msg = 'Expense Updated successfully';

        return redirect()->back()->with('alert-info', $msg);
    }

    ///// delete expense
    public function delete_expense (Request $request) {
        $id = $request->id;
        Expenses::where('id', $id)->update(['delete_status' => '1']);
    }

    /// approved expense
    public function expense_approve (Request $request) {
        $id = $request->id;
        Expenses::where('id', $id)->update(['status' => '1']);
    }

    /// expense reject
    public function expense_reject (Request $request) {
        $id = $request->id;
        Expenses::where('id', $id)->update(['status' => '2']);
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
        else {
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

        echo json_encode([
            "data" => $data,
        ]);

    }

}
