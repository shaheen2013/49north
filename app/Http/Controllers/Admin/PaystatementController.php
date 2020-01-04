<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class PaystatementController extends Controller
{
    
    function paystatement()
    {
    	$data['user_list'] = User::where('user_type','employee')->get();
    	//print_r($data['user_list']);
    	return view('admin.paystatement',$data);
    	//echo 'hello';
    }
}
