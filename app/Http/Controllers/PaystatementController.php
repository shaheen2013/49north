<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User,Paystatement};
use DB;
class PaystatementController extends Controller
{
	/// Payment list
    function paylist()
    {
    	//$data['user_list'] = User::all();
		$user_list = DB::table('users as  u')
		->leftJoin('paystatements as p', 'u.id', '=', 'p.emp_id')
		->select('p.*','u.id as empid')
		->get();

    	return view('paystatement/index')->with('user_list',$user_list);
    }

    /// get paystatement addview
    //function  


    /// Add Paystatement
    function addpaystatement(Request $request)
    {
      	$data = request()->except(['_token']);
      	$statementname = '';
      	if($request->hasFile('pdfname'))
      	{
            $file = $request->file('pdfname');
            $statementname = rand(11111, 99999). '.'. $file->getClientOriginalExtension();
            $request->file('pdfname')->move("public/paystatement",$statementname);
      	}
      	 $data['pdfname'] = $statementname;
         
  		$empid_exists = Paystatement::find($data['emp_id']);
  		if($empid_exists)
  		{
  			Paystatement::where('emp_id','=',$data['emp_id'])->update($data);
  			$msg = 'Paystatement updated successfully';
  		}
  		else
  		{
  			Paystatement::insert($data);
        	$msg = 'Paystatement added successfully';
    	}
        return redirect()->back()->with('paystatement', $msg);
    }
}
