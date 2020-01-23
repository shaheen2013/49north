<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{RedirectResponse,Request};
use Illuminate\View\View;
use App\{Paystatement};
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
        $user_list = DB::table('users as  u')
            ->leftJoin('paystatements as p', 'u.id', '=', 'p.emp_id')
            ->select('p.*', 'u.id as empid')
            ->get();

        return view('paystatement/index')->with('user_list', $user_list);
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
            'pdfname' => 'required|file|mimes:pdf',
            'description' => 'required|string|max:491',
            'date' => 'required',
           
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = request()->except(['_token']);
            $pdfname = null;

            if ($request->hasFile('pdfname')) {
                $pdfname = fileUpload('pdfname', true);
                // $pdfname = fileUpload('pdfname');
                $data['pdfname'] = $pdfname;
            }

            $emp_id_exists = Paystatement::find($data['emp_id']);

            if ($emp_id_exists) {
                Paystatement::where('emp_id', '=', $data['emp_id'])->update($data);
                return response()->json(['status' => 'success']);
            } else{
                Paystatement::insert($data);
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }

    function addpaystatement(Request $request)
    {
        $data = request()->except(['_token']);
        $statementname = '';
        if ($request->hasFile('pdfname')) {
            $file = $request->file('pdfname');
            $statementname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('pdfname')->move("public/paystatement", $statementname);
        }
        $data['pdfname'] = $statementname;

        $empid_exists = Paystatement::find($data['emp_id']);
        if ($empid_exists) {
            Paystatement::where('emp_id', '=', $data['emp_id'])->update($data);
            $msg = 'Paystatement updated successfully';
        } else {
            Paystatement::insert($data);
            $msg = 'Paystatement added successfully';
        }
        return redirect()->back()->with('alert-info', $msg);
    }

    public function searchPaymentPage(Request $request){
        $data = DB::table('users as  u')
            ->leftJoin('paystatements as p', 'u.id', '=', 'p.emp_id')
            ->select('p.*', 'u.id as empid')
            ->where(function ($q) use($request){
                if(isset($request->from) && isset($request->to)){
                    $q->whereBetween('date', [$request->from, $request->to]);
                }
            });

        $data= $data->get();

        foreach ($data as &$datum) {
            $datum->pdfname = fileUrl($datum->pdfname, true);
        }

        return response()->json(['status'=>'success', 'data' => $data]);
    }


}
