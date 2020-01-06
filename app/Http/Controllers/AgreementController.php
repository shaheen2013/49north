<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AgreementController extends Controller
{
    
        function add_empagreement(Request $request)
    {
            if($request->hasFile('agreement_file')) 
            { 
                $file = $request->file('agreement_file');
                $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            }  
                 $conditions = array('emp_id'=>$request->employee_id);    
            if($request->agreement_type == 'EA')
            {   
                $request->file('agreement_file')->move("public/agreement", $name);
                $agreement_details = DB::table('agreements')->where($conditions)->first();
                if($agreement_details)
                {
                    DB::table('agreements')->where($conditions)->update(
                    [   'emp_id' => $request->employee_id,                     
                        'agreement' => $name,
                        'old_agreement' => $agreement_details->agreement,
                    ]);
                }  
                else
                {
                        DB::table('agreements')->insert(
                        ['emp_id' => $request->employee_id,
                        'agreement' => $name,
                        'old_agreement' => $name,
                        ]
                    );
                }


            }
            else
            {   
                $request->file('agreement_file')->move("public/codeofconduct", $name);
                $agreement_details = DB::table('codeofconduct')->where($conditions)->first();
                if($agreement_details)
                {
                    DB::table('codeofconduct')->where($conditions)->update(
                    [   'emp_id' => $request->employee_id,                     
                        'coc_agreement' => $name,
                        'old_coc' => $agreement_details->coc_agreement,
                    ]);
                }
                else
                {
                        DB::table('codeofconduct')->insert(
                        ['emp_id' => $request->employee_id,
                        'coc_agreement' => $name,
                        'old_coc' => '',
                        ]
                    );
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
            $queries = DB::table('agreements')->where(['emp_id', $id])->update(['status' => 'D']);
        }
        if ($type == 'COC') {
            $queries = DB::table('codeofconduct')->where('emp_id', $id)->update(['status' => 'D']);
        }

        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);

    }

}
