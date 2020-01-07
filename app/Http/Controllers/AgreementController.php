<?php

namespace App\Http\Controllers;

use App\{Agreement, Codeofconduct, Employee_detail};
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\View\View;

class AgreementController extends Controller {

    /**
     * @return Factory|View
     */
    function agreementlist () {
        $q = Employee_detail::orderBy('firstname')->with('activeAgreement', 'activeCodeofconduct', 'activeAgreement.amendments');

        /// if employee is not admin
        if (auth()->user()->is_admin == 0) {
            $q->where('id', auth()->user()->id);
        }
        $users = $q->get();

        return view('agreement_listnew', compact('users'));
    }

    function addagreement(Request $request)
    {
        if ($request->hasFile('agreement_file')) {
            $file = $request->file('agreement_file');
            $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
        }
        $conditions = ['emp_id' => $request->employee_id];
        if ($request->agreement_type == 'EA') {
            $request->file('agreement_file')->move("public/agreement", $name);
            $agreement_details = DB::table('agreements')->where($conditions)->first();
            if ($agreement_details) {
                $update_result =	DB::table('agreements')->where($conditions)->update([
                    //'emp_id'        => $request->employee_id,
                    'agreement'     => $name,
                    'old_agreement' => $agreement_details->agreement,
                ]);
               // if($update_result) echo json_encode(array(''));
              if($update_result)  return Response::json(['status' =>'success', 'desc' => 'Updated successfully']);

            }
            else {
                $insert_result = DB::table('agreements')->insert([
                        'emp_id'        => $request->employee_id,
                        'agreement'     => $name,
                        'old_agreement' => $name,
                    ]);
                if($insert_result)  return Response::json(['status' =>'success', 'desc' => 'Added successfully']);
            }

        }
        else {
            $request->file('agreement_file')->move("public/codeofconduct", $name);
            $agreement_details = DB::table('codeofconducts')->where($conditions)->first();
            if ($agreement_details) {
                $coc_result = DB::table('codeofconducts')->where($conditions)->update([
                    'coc_agreement' => $name,
                    'old_coc'       => $agreement_details->coc_agreement,
                ]);
                if($coc_result)return Response::json(['status' =>'success', 'desc' => 'Updated successfully']);
            }
            else {
                $coc_insertres = DB::table('codeofconducts')->insert([
                        'emp_id'        => $request->employee_id,
                        'coc_agreement' => $name,
                        'old_coc'       => '',
                    ]);
                if($coc_insertres)  return Response::json(['status' =>'success', 'desc' => 'Added successfully']);
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
            $agreement = Agreement::where('id', $id)->first();
        }
        else {
            $agreement = Codeofconduct::where('id', $id)->first();
        }

        $agreement->delete();

        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);
    }

}
