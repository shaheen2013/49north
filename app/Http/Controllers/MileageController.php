<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Auth, DB};
use App\{Company, Mileage};
use Illuminate\View\View;

class MileageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    public function mileagelist(Request $request)
    {
        $type = auth()->user()->is_admin;
        if ($type) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

        if ($type == '1') {
            $data['mileage_list'] = Mileage::where('status', '<>', 'D')->orderByDesc('date')->with('employee:id,firstname,lastname')->get();
        }
        else {
            $data['mileage_list'] = Auth::user()->mileage()->where('status', 'A')->orderByDesc('date')->get();

        }

        $data['companies'] = Company::all();
        $date_key = $request->date;

        return view('mileagelist', $data, compact('activeMenu'))->with('date_key', $date_key);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchPendingMileage (Request $request) {

        $data = $this->_searchMileage('search', true);

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['pending'] = route('mileage.pending', $datum->id);
                $routes['approve'] = route('mileage.approve', $datum->id);
                $routes['reject'] = route('mileage.reject', $datum->id);
                $datum->routes = $routes;
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * @param string $searchField
     * @param bool   $isPending
     *
     * @return mixed
     */
    private function _searchMileage ($searchField, $isPending = true) {
        $query = Mileage::orderByDesc('date')->with('employee');

        if ($search = request()->input($searchField)) {
            $query->whereHas('employee', function ($sql) use ($search) {
                $sql->where('firstname', 'LIKE', '%' . $search . '%');
                $sql->orWhere('lastname', 'LIKE', '%' . $search . '%');
            });
        }

        $query->dateSearch('date');
        $query->isEmployee();

        // pending has not status
        if ($isPending) {
            $query->whereNull('status');
        }
        else {
            $query->whereNotNull('status');
        }

        return $query->get();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function searchHistoryMileage (Request $request) {

        $data = $this->_searchMileage('history_search', false);
        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['pending'] = route('mileage.pending', $datum->id);
                $routes['destroy'] = route('mileage.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);

    }

    /**
     * @param Request $request
     */
    public function addmileage (Request $request) {
        $mileagearray = [
            'emp_id'        => auth()->user()->id,
            'company'       => $request->companyname,
            'date'          => $request->date,
            'vehicle'       => $request->vehicle,
            'kilometers'    => $request->kilometers,
            'reasonmileage' => $request->reasonformileage,
        ];

        DB::table('mileages')->insert($mileagearray);

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function edit (Request $request) {

        $q = Mileage::where('id', $request->input('id'));

        // if not admin, ensure they are only loading their own data
        if (!auth()->user()->is_admin) {
            $q->where('emp_id', auth()->user()->id);
        }

        $data['mileage'] = $q->first();
        $data['companies'] = Company::all();
        if ($data) {
            return response()->json(['status' => 'success', 'data' => $data]);
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update (Request $request) {

        $input = $request->only(['company', 'date', 'vehicle', 'kilometers', 'reasonmileage']);
        if ($id = $request->input('id')) {

            $data = Mileage::find($request->input('id'));

            if ($data->update($input)) {
                return response()->json(['status' => 'success']);
            }
        }
        else {
            $input['emp_id'] = Auth::user()->id;
            $data = Mileage::create($input);
            if ($data) {
                return response()->json(['status' => 'success']);
            }
        }

        return response()->json(['status' => 'fail']);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy (Request $request) {
        $mileage = Mileage::findOrFail($request->input('id'));
        if ($mileage->delete() == 1) {
            $success = true;
            $message = "Mileage deleted successfully";
        }
        else {
            $success = false;
            $message = "Mileage not found";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /// Pending mileage
    public function mileagePending($id)
    {
        $data = Mileage::find($id);
        $data->status = null;
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);

    }

    /// approved mileage
    public function mileageApprove($id)
    {
        $data = Mileage::find($id);
        $data->status = 'A';
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);

    }

    /// reject mileage
    public function mileageReject ($id) {
        $data = Mileage::find($id);
        $data->status = 'D';
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);

    }

}
