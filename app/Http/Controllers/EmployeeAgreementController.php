<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EmployeeAgreementController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        // $this->middleware('auth');
    }

    /**
     * @return Factory|View
     */
    function agreementlist () {
        $emp_id = auth()->user()->id;
        $employee = DB::table('employee_details as ed')->leftjoin('agreements as a', 'ed.id', '=', 'a.emp_id')
            ->select('ed.id', 'ed.firstname', 'ed.created_at', 'ed.lastname', 'ed.personalemail', 'a.agreement', 'a.agreement_type')->where('emp_id', '=', $emp_id)->get();

        return view('employee_agreement')->with('employee', $employee);
    }

}
