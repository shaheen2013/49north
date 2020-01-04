<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Employee_detail;
use App\User;
use App\Agreeement;
class EmployeeAgreementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }



    function agreementlist()
    {   $emp_id  =  auth()->user()->emp_id;
        $employee = DB::table('employee_details as ed')
            ->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')            
            ->select('ed.id','ed.firstname','ed.created_at','ed.lastname','ed.personalemail','a.agreement','a.agreement_type')
            ->where('emp_id','=',$emp_id)->get();
            return view('employee_agreement')->with('employee', $employee);
    }

  
    


}
