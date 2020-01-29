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
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

    	$data['maintanance'] = Maintenance_ticket::where(['delete_status' => NULL, 'status' => NULL])->with('employee:id,firstname,lastname')->get();
        $data['maintanance1'] = Maintenance_ticket::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->with('employee:id,firstname,lastname')->get();
        $data['category'] = Categorys::all();

    	return view('maintenance.index', $data, compact('activeMenu'));
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
        Maintenance_ticket::destroy($request->id);

        $msg = 'Ticket deleted';
        return redirect()->back()->with('alert-info',$msg);
    }

    function ticket_inprogress(Request $request)
    {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['status' => 1]);

        return response()->json(['status' => 200]);
    }

    public function ticket_cancel (Request $request) {
        $id = $request->id;
        Maintenance_ticket::where(['id' => $id])->update(['status' => 2]);
    }

    /**
     * Filter agreement
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){
        try {
            $data = Maintenance_ticket::select('maintenance_tickets.*')->with('employee')
                ->leftjoin('employee_details AS emp','emp.id','=','maintenance_tickets.emp_id')
                ->where(function ($q) use ($request) {
                    if (isset($request->search)) {
                        $q->where(function ($query) use ($request) {
                            $query->where('maintenance_tickets.subject', 'like', '%' . $request->search . '%')
                                ->orWhere('maintenance_tickets.status', 'like', '%' . $request->search . '%')
                                ->orWhere(\DB::raw("CONCAT(emp.firstname, ' ', emp.lastname)"), 'like', '%' . $request->search . '%')
                                ->orWhere('maintenance_tickets.updated_at', 'like', '%' . $request->search . '%');
                        });
                    }
                    if (isset($request->from) && isset($request->to)) {
                        $q->whereBetween('maintenance_tickets.updated_at', [$request->from, $request->to]);
                    }
                    if ($request->id == 'completed') {
                        $q->where('maintenance_tickets.status', '>', 0);
                    } else {
                        $q->whereNull('maintenance_tickets.status');
                    }
                })->isEmployee()->get();

            foreach ($data as $datum) {
                $datum->updated_at_formatted = date('d M, Y', strtotime($datum->updated_at));
            }

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
