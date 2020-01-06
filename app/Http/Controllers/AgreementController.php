<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Support\Facades\DB;

class AgreementController extends Controller {

    /**
     * @param Request $request
     */
    function add_empagreement (Request $request) {
        if ($request->hasFile('agreement_file')) {
            $file = $request->file('agreement_file');
            $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
        }
        $conditions = ['emp_id' => $request->employee_id];
        if ($request->agreement_type == 'EA') {
            $request->file('agreement_file')->move("public/agreement", $name);
            $agreement_details = DB::table('agreements')->where($conditions)->first();
            if ($agreement_details) {
                DB::table('agreements')->where($conditions)->update([
                    'emp_id'        => $request->employee_id,
                    'agreement'     => $name,
                    'old_agreement' => $agreement_details->agreement,
                ]);
            }
            else {
                DB::table('agreements')->insert([
                        'emp_id'        => $request->employee_id,
                        'agreement'     => $name,
                        'old_agreement' => $name,
                    ]);
            }

        }
        else {
            $request->file('agreement_file')->move("public/codeofconduct", $name);
            $agreement_details = DB::table('codeofconduct')->where($conditions)->first();
            if ($agreement_details) {
                DB::table('codeofconduct')->where($conditions)->update([
                    'emp_id'        => $request->employee_id,
                    'coc_agreement' => $name,
                    'old_coc'       => $agreement_details->coc_agreement,
                ]);
            }
            else {
                DB::table('codeofconduct')->insert([
                        'emp_id'        => $request->employee_id,
                        'coc_agreement' => $name,
                        'old_coc'       => '',
                    ]);
            }
        }
    }

    /**
     * @param $id
     * @param $type
     *
     * @return JsonResponse
     */
    function destroy ($id, $type) {
        if ($type == 'EA') {
            DB::table('agreements')->where(['emp_id', $id])->update(['status' => 'D']);
        }
        if ($type == 'COC') {
            DB::table('codeofconduct')->where('emp_id', $id)->update(['status' => 'D']);
        }

        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);

    }

    /**
     * @return Factory|View
     */
    function employee_agreementlist () {
        $employee = DB::table('employee_details as ed')->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')->leftjoin('codeofconduct as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement')->where(['ed.id' => auth()->user()->emp_id])
            ->get();

        return view('agreement_listnew')->with('employee', $employee);
    }

    /**
     * @return Factory|View
     */
    public function agreement_list () {
        $employee = DB::table('employee_details as ed')->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')->leftjoin('codeofconduct as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement')
            //->where(array('a.status'=>'A','coc.status'=>'A'))
            ->get();

        return view('admin.agreement_list')->with('employee', $employee);

    }
}
