<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Company, Project, Purchases, Categorys, Expenses};
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if(auth()->user()->is_admin == 1){
        $activeMenu = 'company';

        return view('company.companyreport', compact('activeMenu'));
        }
        else{
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->is_admin == 1){
            $data = null;
            if($data){
                return response()->json(['status'=>'success', 'data'=>$data]);
            }
            return response()->json(['status'=>'fail']);
        }
        else{
            abort(401);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
       
            // Validate form data
            $rules = [
                'companyname' => 'required|string|max:191',
                'email' => 'nullable|email',
                'logo' => 'nullable|image',
            ];

            $validator = validator($request->all(), $rules, []);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
            }

            try {
                $data = $request->all();
                $logo = null;

                if ($request->hasFile('logo')) {
                    $logo = fileUpload('logo');
                    $data['logo'] = $logo;
                }

                $check = Company::create($data);

                if ($check) {
                    return response()->json(['status' => 'success']);
                }

                return response()->json(['status' => 'fail']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
            }
        
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
        if(auth()->user()->is_admin == 1){
            $data = Company::findOrFail($id);
            if($data){
                return response()->json(['status'=>'success', 'data'=>$data]);
            }
            return response()->json(['status'=>'fail']);
        }
        else{
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
       
            // Validate form data
            $rules = [
                'companyname' => 'required|string|max:191',
                'email' => 'nullable|email',
                'logo' => 'nullable|image',
            ];

            $validator = validator($request->all(), $rules, []);

            if ($validator->fails()) {
                return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
            }

            try {// return $request->all();
                $data = Company::findOrFail($id);
                $logo = null;

                if ($request->hasFile('logo')) {
                    Storage::delete($data->logo);
                    $data->logo = fileUpload('logo');
                }

                $data->companyname = $request->companyname;
                $data->email = $request->email;

                if ($data->update()) {
                    return response()->json(['status' => 'success']);
                }

                return response()->json(['status' => 'fail']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
            }
        
    }

    public function searchCompanyPage(Request $request){

      

            $data = Company::where(function ($q) use($request){
                    if(isset($request->search)){
                        $q->where('companyname', 'LIKE', '%'.$request->search.'%');
                    }
                });
                $data= $data->orderBy('companyname', 'asc')->get();
            return response()->json(['status'=>'success', 'data' => $data]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        
            try {
                $company = Company::findOrFail($id);
                Storage::delete($company->logo);

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
            } catch (\Exception $e) {
                return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
            }
           

    }
}
