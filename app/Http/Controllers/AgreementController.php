<?php

namespace App\Http\Controllers;
use Response;
use App\Agreement;
use App\Codeofconduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AgreementController extends Controller
{
    function agreementlist()
    {
    	$employee = DB::table('employee_details as ed')->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')->leftjoin('codeofconducts as coc', 'ed.id', '=', 'coc.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'coc.coc_agreement');
            
            /// if employee is not admin
            if(auth()->user()->is_admin == 0)
            {
             $employee->where(array('ed.id'=>auth()->user()->id,'a.deleted_at'=>NULL));
            }
            $result = $employee->get();

       return view('agreement_listnew')->with('agreement', $result);
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


    function destroy ($id, $type) {
        if ($type == 'EA') {
          // DB::table('agreements')->where(['emp_id', $id])->update(['status' => 'D']);
         $agreement =   Agreement::where('emp_id',$id)->first();
         //$success = $agreement->exists ? true : false;
         $agreement->delete();
        }
        if ($type == 'COC') {
            //DB::table('codeofconduct')->where('emp_id', $id)->update(['status' => 'D']);
        	$coc =   Codeofconduct::where('emp_id',$id)->first();
	        // $success = $coc->exists ? true : false;
	         $coc->delete();
        }

        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);
    }

}
