<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\{Mail\MaintenanceNotify, User, Expenses, Company, Project, Purchases, Categorys, Maintenance_ticket};
use DB;
class MaintenanceController extends Controller
{
	// Maintennace List
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
        $data['users'] = User::where('is_admin', 0)->get();

    	return view('maintenance.index', $data, compact('activeMenu'));
    }

    // Add maintenance
    function addmaintenance(Request $request)
    {
        $request->validate([
            'user' => 'nullable|array'
        ]);

        $data = $request->all();
        unset($data['user']);

        $maintenance = Maintenance_ticket::create($data);

        if (count($request->user)) {
            $maintenance->users()->attach($request->user);
            Mail::to(User::find($request->user)->pluck('email'))->send(new MaintenanceNotify($request));
        }

        $msg = 'Ticket Added successfully';

        return redirect()->back()->with('alert-info', $msg);
    }

    // edit view
    function edit_maintenanceview(Request $request)
    {
    	$data['maintanance'] = Maintenance_ticket::find($request->id)->first();
        $data['category'] = Categorys::all();
        $data['categorya1'] = Categorys::where('id', $data['maintanance']->category)->first();
        $data['users'] = User::where('is_admin', 0)->get();

     	return view('ajaxview.editmaintenance', $data);
    }

    // update maintenance
    function edit(Request $request)
    {
    	$id = $request->id;
        $data = $request->all();
        unset($data['user']);
        $try = Maintenance_ticket::where(['id' => $id])->update($data);
        $maintenance = Maintenance_ticket::find($id);
        $msg = 'Updated a ticket';

        $maintenance->users()->detach();
        if (count($request->user)) {
            $maintenance->users()->attach($request->user);
            Mail::to(User::find($request->user)->pluck('email'))->send(new MaintenanceNotify($request));
        }

        return redirect()->back()->with('alert-info', $msg);
    }

    // delete tickets
    function delete(Request $request)
    {
        Maintenance_ticket::destroy($request->id);
        $msg = 'Ticket deleted';
        \Session::flash('alert-info', $msg);

        return redirect()->route('maintenance.list');
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
    public function search(Request $request)
    {
        try {
            $tagged = [];
            if (!auth()->user()->is_admin) {
                $tagged = array_unique(auth()->user()->tickets->pluck('id')->toArray());
            }

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
                })
                ->where(function ($q) use ($tagged) {
                    if (!auth()->user()->is_admin && count($tagged)) {
                        $q->whereIn('maintenance_tickets.id', $tagged);
                    }
                })->isEmployee()->get();

                if (count($data)) {
                    foreach ($data as $datum) {
                        $routes = [];
                        $routes['commentStore'] = route('maintenance.comment.store', $datum->id);
                        $routes['commentUpdate'] = route('maintenance.comment.update', $datum->id);
                        $routes['edit'] = route('maintenance.editview');
                        // $routes['update'] = route('maintenance.update', $datum->id);
                        $routes['show'] = route('maintenance.show', $datum->id);
                        $routes['destroy'] = route('maintenance.delete');
                        $datum->routes = $routes;
                    }
                }

            foreach ($data as $datum) {
                $datum->updated_at_formatted = date('d M, Y', strtotime($datum->updated_at));
            }

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }
        $show = Maintenance_ticket::with('employee')->find($id);

        if ($show->comment)
        {
            $route = route('maintenance.comment.update', $show->id);
        } else {
            $route = route('maintenance.comment.store', $show->id);
        }

        $editRoute = route('maintenance.editview', $id);

        $deleteRoute = route('maintenance.delete');
        return view('maintenance.show', compact('show', 'user', 'activeMenu', 'route', 'editRoute', 'deleteRoute'));
    }

    public function commentStore(Request $request, $id)
    {

        // Validate form data
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = Maintenance_ticket::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->save()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }

    public function commentUpdate(Request $request, $id)
    {

        // Validate form data
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = Maintenance_ticket::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->update()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }
}
