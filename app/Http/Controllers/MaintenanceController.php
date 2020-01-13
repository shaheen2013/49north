<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User,Expenses,Company,Project,Purchases,Categorys,Maintenance_ticket};
use DB;
class MaintenanceController extends Controller
{

	/// Maintennace List
    function Maintenance_list()
    {
    	$data['maintanance'] = Maintenance_ticket::where(['delete_status' => NULL, 'status' => NULL])->with('employee:id,firstname,lastname')->get();
        $data['maintanance1'] = Maintenance_ticket::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->with('employee:id,firstname,lastname')->get();
        $data['category'] = Categorys::all();
    	return view('maintenance.index',$data);
    }


    /// Add maintenance
    function addmaintenance(Request $request)
    {
    	$data = $request->all();
        Maintenance_ticket::insert($data);
        $msg = 'Ticket Added successfully';
        return redirect()->back()->with('alert-info', $msg);
    }

   ///// edit view
    function edit_maintenanceview(Request $request)
    {
    	$data['maintanance'] = DB::table('maintenance_tickets')->where('id', $request->id)->first();
        $data['category'] = Categorys::all();
        $data['categorya1'] = Categorys::where('id', $data['maintanance']->category)->first();

     	return view('ajaxview.editmaintenance',$data);
    }

    /// update maintenance
    function edit(Request $request)
    {
    	$id = $request->id;
        $data = $request->all();
        $try = Maintenance_ticket::where(['id' => $id])->update($data);
        $msg = 'Updated a ticket';
        return redirect()->back()->with('alert-info', $msg);
    }

    /// delete tickets
    function delete(Request $request)
    {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['delete_status' => 1]);
        $msg = 'Ticket deleted';
        return redirect()->back()->with('alert-info',$msg);
    }


    function ticket_inprogress(Request $request)
    {
         $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['status' => 1]);
    }


    public function ticket_cancel (Request $request) {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['status' => 2]);
    }
}
