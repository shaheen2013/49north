<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\{Company, Mileage, Project, Purchases, Categorys};
use Illuminate\View\View;

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
     * @return Factory|View
     */
    public function mileagelist (Request $request) {

        $type = auth()->user()->is_admin;
        if ($type == '1') {
            $data['mileage_list'] = Mileage::where('status','<>','D')->orderByDesc('created_at')->with('employee:id,firstname,lastname')->get();
        }
        else {
            $data['mileage_list'] = Auth::user()->mileage()->where('status','A')->orderByDesc('created_at')->get();

        }

        $data['companies'] = Company::all();
        $date_key = $request->date;

        return view('mileagelist', $data)->with('date_key',$date_key);
    }

    public function searchMileage(Request $request){
        $type = auth()->user()->is_admin;
        if ($type == '1') {
            $data = Mileage::orderByDesc('created_at')->with('employee:id,firstname,lastname')
            ->where(function ($q) use($request){
                if(isset($request->search)){
                    $q->whereHas('employee', function($sql) use($request){
                        $sql->where('firstname', 'LIKE', '%'.$request->search.'%');
                        $sql->orWhere('lastname', 'LIKE', '%'.$request->search.'%');
        
                    });
                    
                }
                if(isset($request->from) && isset($request->to)){
                    $q->whereBetween('date', [$request->from, $request->to]);
                    // $q->whereBetween('date', array($request->from, $request->to));
                }
            });

            $data= $data->get();
            return response()->json(['status'=>'success', 'data' => $data]);
        }

        else {
            $data = Auth::user()->mileage()->where('status','A')->orderByDesc('created_at')
            ->where(function ($q) use($request){
                if(isset($request->date)){
                    $q->whereDate('date', '=',$request->date);
                }
            });

            $data= $data->get();
            return response()->json(['status'=>'success', 'data' => $data]);

        }
        return response()->json(['status'=>'success', 'data' => $data]);
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
     *
     * @return RedirectResponse
     */
   
    /**
     * @param $id
     *
     * @return Factory|View
     */
    

    public function edit($id)
    {
        $emp_id = auth()->user()->id;
        $data['mileage'] = Mileage::findOrFail($id)->where(['emp_id' => $emp_id])->first();
        $data['companies'] = Company::all();
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    public function update(Request $request, $id)
    {
        
       $data= Mileage::find($id);
        $data->company = $request->company;
        $data->date = $request->date;
        $data->vehicle = $request->vehicle;
        $data->kilometers = $request->kilometers;
        $data->reasonmileage = $request->reasonmileage;

        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $mileage = Mileage::findOrFail($id);
        if ($mileage->delete() == 1) {
            $success = true;
            $message = "Mileage deleted successfully";
        } else {
            $success = false;
            $message = "Mileage not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

}
