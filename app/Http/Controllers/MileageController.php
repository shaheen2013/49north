<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;

class MileageController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return void
     */
    public function mileagelist (Request $request) {
       
        $emp_id = auth()->user()->id;
        $type = auth()->user()->is_admin;
        if ($type == '1') {
            $mileage_list = DB::table('mileages')->get();
        }
        else {
            $mileage_list = DB::table('mileages')->where(['emp_id' => $emp_id, 'status' => 'A'])->get();
        }
        
        return view('mileagelist')->with('mileage_list',$mileage_list);
    }

    /**
     * @param Request $request
     */
    public function addmileage (Request $request) {
        $mileagearray = [
            'emp_id'        => auth()->user()->id,
            'company'       => $request->companyname,
            'date'          => $request->date,
            'vehicle'       => $request->vehicle,
            'kilometers'    => $request->kilometers,
            'reasonmileage' => $request->reasonformileage,
        ];

        DB::table('mileages')->insert($mileagearray);

    }

    /**
     * @param Request $request
     */
    function updatemileage (Request $request) {
        $emp_id = auth()->user()->id;
        $conditions = ['id' => $request->editmileage_id, 'emp_id' => $emp_id];
        DB::table('mileages')->where($conditions)->update([
            'date'          => $request->date,
            'company'       => $request->companyname,
            'vehicle'       => $request->vehicle,
            'kilometers'    => $request->kilometers,
            'reasonmileage' => $request->reasonformileage,
        ]);

    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function get_mileage ($id) {
        $data['companies'] = Company::all();
        $emp_id = auth()->user()->id;
        $type = auth()->user()->user_type;
        if ($type == 'is_admin') {
            $mileage_list = DB::table('mileages')->first();
        }
        else {
            $data['mileagedetails'] = DB::table('mileages')->where(['id' => $id, 'emp_id' => $emp_id])->first();
        }

        return view('mileage', $data);
    }

    /**
     * @param $id
     */
    function deletemileage ($id) {
        $emp_id = auth()->user()->id;
        $conditions = ['id' => $id, 'emp_id' => $emp_id];
        DB::table('mileages')->where($conditions)->update(['status' => 'D']);

    }

}
