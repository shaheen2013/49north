<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use App\{Mail\MaintenanceNotify, User, Expenses, Company, Project, Purchases, Categorys, MaintenanceTicket};
use DB;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    function maintenanceList ()
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        }
        else {
            $activeMenu = 'submit';
        }

        $data['maintanance'] = MaintenanceTicket::where(['delete_status' => NULL, 'status' => NULL])->with('employee:id,firstname,lastname')->get();
        $data['maintanance1'] = MaintenanceTicket::where(['delete_status' => NULL, 'status' => 1])->orWhere(['status' => 2])->with('employee:id,firstname,lastname')->get();
        $data['category'] = Categorys::all();
        $data['users'] = User::where('is_admin', 0)->get();

        return view('maintenance.index', $data, compact('activeMenu'));
    }

    /**
     * Add maintenance
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    function addMaintenance (Request $request) {
        $request->validate([
            'user' => 'nullable|array'
        ]);

        $data = $request->all();
        unset($data['user']);

        $maintenance = MaintenanceTicket::create($data);

        if (count($request->user)) {
            $maintenance->users()->attach($request->user);
            Mail::to(User::find($request->user)->pluck('email'))->send(new MaintenanceNotify($request));
        }

        $msg = 'Ticket Added successfully';

        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * edit view
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    function editMaintenanceView (Request $request) {
        $data['maintanance'] = MaintenanceTicket::find($request->id);
        $data['category'] = Categorys::all();
        $data['categorya1'] = Categorys::where('id', $data['maintanance']->category)->first();
        $data['users'] = User::where('is_admin', 0)->get();

        return view('ajaxview.editmaintenance', $data);
    }

    /**
     * update maintenance
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    function edit (Request $request) {
        $id = $request->id;
        $data = $request->all();
        unset($data['user']);
        $try = MaintenanceTicket::where(['id' => $id])->update($data);
        $maintenance = MaintenanceTicket::findOrFail($id);
        $msg = 'Updated a ticket';

        $maintenance->users()->detach();
        if (count($request->user)) {
            $maintenance->users()->attach($request->user);
            Mail::to(User::find($request->user)->pluck('email'))->send(new MaintenanceNotify($request));
        }

        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * delete tickets
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    function delete (Request $request) {
        MaintenanceTicket::destroy($request->id);
        $msg = 'Ticket deleted';
        session()->flash('alert-info', $msg);

        return redirect()->route('maintenance.list');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    function ticketInProgress (Request $request) {
        $id = $request->id;
        MaintenanceTicket::where(['id' => $id])->update(['status' => 1]);

        return response()->json(['status' => 200]);
    }

    /**
     * @param Request $request
     */
    public function ticketCancel (Request $request) {
        $id = $request->id;
        MaintenanceTicket::where(['id' => $id])->update(['status' => 2]);
    }

    /**
     * Filter agreement
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search (Request $request)
    {
        try {
            $tagged = [];
            if (!auth()->user()->is_admin) {
                $tagged = array_unique(auth()->user()->tickets->pluck('id')->toArray());
                $ids = MaintenanceTicket::where('emp_id', auth()->user()->id)->pluck('id')->toArray();
                $tagged = array_merge($tagged, $ids);
            }

            $data = MaintenanceTicket::select('maintenance_tickets.*')
                ->with('employee')
                ->leftjoin('employee_details AS emp', 'emp.id', '=', 'maintenance_tickets.emp_id')
                ->where(function ($q) use ($request, $tagged) {
                    if (isset($request->search)) {
                        $q->where(function ($query) use ($request) {
                            $query->where('maintenance_tickets.subject', 'like', '%' . $request->search . '%')
                                ->orWhere('maintenance_tickets.status', 'like', '%' . $request->search . '%')
                                ->orWhere(DB::raw("CONCAT(emp.firstname, ' ', emp.lastname)"), 'like', '%' . $request->search . '%')
                                ->orWhere('maintenance_tickets.updated_at', 'like', '%' . $request->search . '%');
                        });
                    }
                    if (isset($request->from) && isset($request->to)) {
                        $q->whereBetween('maintenance_tickets.updated_at', [$request->from, $request->to]);
                    }
                    if ($request->id == 'completed') {
                        $q->where('maintenance_tickets.status', '>', 0);
                    }
                    else {
                        $q->whereNull('maintenance_tickets.status');
                    }
                    if (!auth()->user()->is_admin) {
                        $q->whereIn('maintenance_tickets.id', $tagged);
                    }
                })->get();

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
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     *
     * @return Factory|View
     */
    public function show ($id) {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        }
        else {
            $activeMenu = 'submit';
        }
        $show = MaintenanceTicket::with('employee')->findOrFail($id);

        if ($show->comment) {
            $route = route('maintenance.comment.update', $show->id);
        }
        else {
            $route = route('maintenance.comment.store', $show->id);
        }

        $editRoute = route('maintenance.editview', $id);

        $deleteRoute = route('maintenance.delete');

        return view('maintenance.show', compact('show', 'user', 'activeMenu', 'route', 'editRoute', 'deleteRoute'));
    }

    /**
     * @param Request $request
     * @param       int  $id
     *
     * @return JsonResponse
     */
    public function commentStore (Request $request, $id) {

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
            $data = MaintenanceTicket::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->save()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }

    /**
     * @param Request $request
     * @param       int  $id
     *
     * @return JsonResponse
     */
    public function commentUpdate (Request $request, $id) {

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
            $data = MaintenanceTicket::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->update()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }
}
