<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, Project, Purchases, Categorys, Expenses};

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::all();
        return view('company.companyreport', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = null;
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $logo = '';
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('logo')->move("logo", $logo);
        }

        $data['logo'] = $logo;

        $check = Company::create($data);
        if ($check) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::findOrFail($id);
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $data = Company::findOrFail($id);
        $logo = '';
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $logo = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('logo')->move("logo", $logo);
           
        }
        $data->companyname = $request->companyname;
        $data->email =  $request->email;
        $data->logo = $logo;
        // $data->save();

        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
    }

    public function searchCompanyPage(Request $request){

        $data = Company::where(function ($q) use($request){
                if(isset($request->search)){
                    $q->where('companyname', 'LIKE', '%'.$request->search.'%');
                }
            });
            $data= $data->get();
        return response()->json(['status'=>'success', 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        if ($company->delete() == 1) {
            $success = true;
            $message = "Company deleted successfully";
        } else {
            $success = false;
            $message = "Company not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
