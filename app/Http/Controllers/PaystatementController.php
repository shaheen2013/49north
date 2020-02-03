<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\View\View;
use App\{Paystatement, Employee_detail, User};
use Illuminate\Support\Facades\DB;

class PaystatementController extends Controller
{
    /**
     * Payment List
     * @return Factory|View
     */
    function paylist()
    {
        //$data['user_list'] = User::all();
        $activeMenu = 'profile';
        $user_list = DB::table('users as  u')
            ->leftJoin('paystatements as p', 'u.id', '=', 'p.emp_id')
            ->select('p.*', 'u.id as empid')
            ->get();
        $user = User::where('is_admin', 0)->get();

        return view('paystatement/index', compact('user_list', 'user', 'activeMenu'));
    }

    /**
     * Add New Payment
     *
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request)
    {
        // Validate form data
        $rules = [
            'emp_id' => 'required',
            'pdfname' => 'required|file|mimes:pdf',
            'description' => 'required|string|max:491',
            'date' => 'required',

        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = $request->all();
            $pdfname = null;

            if ($request->hasFile('pdfname')) {
                $pdfname = fileUpload('pdfname', true);
                // $pdfname = fileUpload('pdfname');
                $data['pdfname'] = $pdfname;
            }
            $data['created_at'] = Carbon::now();

            $check = Paystatement::insert($data);

            if ($check) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'fail']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }

    public function searchPaymentPage(Request $request)
    {
        $data = Paystatement::orderByDesc('date')->with('employee')
            ->where(function ($q) use ($request) {
                if (isset($request->search)) {
                    $q->whereHas('employee', function ($sql) use ($request) {
                        $sql->where('firstname', 'LIKE', '%' . $request->search . '%');
                        $sql->orWhere('lastname', 'LIKE', '%' . $request->search . '%');

                    });

                }
                if (auth()->user()->is_admin != 1) {
                    $q->where('emp_id', auth()->user()->id);
                }
            });
        $data = $data->dateSearch('date');
        $data = $data->isEmployee()->get();
        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['destroy'] = route('paystatement.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }

        foreach ($data as &$datum) {
            $datum->pdfname = fileUrl($datum->pdfname, true);
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function destroy($id)
    {
        if (auth()->user()->is_admin == '1') {
            $pay = Paystatement::where('id', $id)->first();
            if ($pay->delete() == 1) {
                $success = true;
                $message = "pay Statements deleted successfully";
            } else {
                $success = false;
                $message = "pay Statements not found";
            }
        } else {
            $message = "You can't delete. Only Admin can delete!!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }


}
