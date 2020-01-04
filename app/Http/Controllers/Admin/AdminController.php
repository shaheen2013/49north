<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Expenses;
use App\Company;
use App\Project;
use App\Purchases;
use App\Categorys;
use DB;
use App\Maintenance_ticket;


class AdminController extends Controller
{
    
    public function index()
    {
    	return view('admin/registration');
    }

    public function expences_report(){
    	$data['expence']= Expenses::where(['delete_status'=> NULL , 'status' => NULL])->get();
    	$data['companies'] =   Company::all();
        $data['project']   =   Project::all();
        $data['purchases'] =   Purchases::all();
        $data['category']  =   Categorys::all();
    	return view('admin/expencesreport', $data);
    }

    public function milegebook(){
    	$data['mileage_list'] = DB::table('mileages')->get();
    	$data['companies'] =   Company::all(); 
    	return view('admin/mileagebook', $data);  
    }

    public function tech_maintanance(){
    	$data['maintanance']= Maintenance_ticket::where(['delete_status'=> NULL , 'status' => NULL])->get();
    	$data['maintanance1']= Maintenance_ticket::where(['delete_status'=> NULL , 'status' => 1])->orWhere(['status' => 2])->get();
    	$data['category']  =   Categorys::all();
    	return view('admin/tech_maintanance', $data); 
    }

    public function timeoff(){
    	return view('admin/timeoff');
    }

    public function reportconcern(){
    	return view('admin/reportconcern');
    }

     protected function add_registration(Request $request)
    {   
        $name = '';
        if($request->hasFile('profilepic')) { 
        $file = $request->file('profilepic');
        $name = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
        $request->file('profilepic')->move("public/profile", $name);
       }
         $employee_detailsarray =array(
            'firstname'=> $request->firstname,
            'lastname' => $request->lastname,
            'personalemail' => $request->personalemail,
            'dob' => $request->dob,
            'phone_no'=> $request->phone,
            'address' => $request->address,
            'profile_pic' => $name, 
            'no_ofchildren'=> $request->noofchildren,
            'family_inarea' => $request->familyinarea,
            'spclfamilycircumstace' => $request->familycircum,
            'prsnl_belief' => $request->personal_belief,
            'known_medical_conditions'=> $request->medical_conditions,
            'allergies' => $request->allergies,
            'dietiary_restricons' => $request->dietary,
            'known_health_concerns' => $request->mental_concerns,
            'aversion_phyactivity'=> $request->aversion_phyactivity,
            'emergency_contact_name' => $request->emergency_contact_name,
            'reltn_emergency_contact' => $request->rel_emer_contact,
            'emergency_contact_email' => $request->emergency_email, 
            'emergency_contact_phone' => $request->emer_contact_phone,
        );

            $check_email=user::where(['email' => $request->personalemail])->count();
            if($check_email == 1){
              return back()->with('error', 'This Email Already Available Please Try Another EMail !!');
            }
        $Employee_detail = Employee_detail::create($employee_detailsarray); 
        $last_id=$Employee_detail->id;
        $user_detail = User::create([
            'emp_id' =>$last_id,
            'name' =>$request->firstname.' '.$request->lastname,
            'password' =>Hash::make($request->password),
            'email' =>$request->personalemail,
            'user_type' => 'employee'
        ]);
        if($user_detail){
           //$role = Role::create(['name' => 'Employe']);
           //$permission = Permission::create(['name' => 'Employe Panel']);
            $role = Role::findByid(2);
            $permission = Permission::findByid(2);
            $role->givePermissionTo($permission);
            $permission->assignRole($role);
            $user_detail->givePermissionTo('Employee Panel');
            $user_detail->assignRole('Employee');
        }

         return back()->with('message', 'Your information is submitted Successfully');
      
    }

}
