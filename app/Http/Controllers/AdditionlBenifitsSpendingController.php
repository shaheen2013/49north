<?php

namespace App\Http\Controllers;

use App\AdditionlBenifitsSpending;
use Illuminate\Http\Request;

class AdditionlBenifitsSpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeMenu = 'benefits';
        $data= AdditionlBenifitsSpending::get();

        return view('additional-benifits-spending.index', compact('activeMenu', 'data'));
    }

    private function _searchPending ($searchField) {
        $query = AdditionlBenifitsSpending::orderByDesc('date')->whereNull('status');
        $query->dateSearch('date');
        // $query->isEmployee();
        return $query->get();
    }

    public function searchPending (Request $request) {

        $data = $this->_searchPending('search');

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    private function _searchHistory ($searchField) {
        $query = AdditionlBenifitsSpending::orderByDesc('date')->whereNotNull('status');
        $query->dateSearch('date');
        // $query->isEmployee();
        return $query->get();
    }

    public function searchHistory (Request $request) {

        $data = $this->_searchHistory('search');

        return response()->json(['status' => 'success', 'data' => $data]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'date' => 'required',
            'description' => 'required|string|max:491',
            'total' => 'required',

        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = $request->all();

            $check = AdditionlBenifitsSpending::create($data);

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
     * @param  \App\AdditionlBenifitsSpending  $additionlBenifitsSpending
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdditionlBenifitsSpending  $additionlBenifitsSpending
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = AdditionlBenifitsSpending::findOrFail($id)->first();
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdditionlBenifitsSpending  $additionlBenifitsSpending
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate form data
       $rules = [
            'description' => 'string|max:491',
    ];

    $validator = validator($request->all(), $rules, []);

    if ($validator->fails()) {
        return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
    }

    try {
        // return $request->all();
        $data = AdditionlBenifitsSpending::findOrFail($id);
        $data->date = $request->date;
        $data->description = $request->description;
        $data->total = $request->total;

        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdditionlBenifitsSpending  $additionlBenifitsSpending
     * @return \Illuminate\Http\Response
     */

     /// approved expense
    public function approve($id)
    {
        $data = AdditionlBenifitsSpending::find($id);
        $data->status = 1;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);

    }

    /// expense reject
    public function reject($id)
    {
        $data = AdditionlBenifitsSpending::find($id);
        $data->status = 2;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);

    }

    /// approved expense
    public function paid($id)
    {
        $data = AdditionlBenifitsSpending::find($id);
        $data->pay_status = 1;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);

    }

    /// expense reject
    public function nonPaid($id)
    {
        $data = AdditionlBenifitsSpending::find($id);
        $data->pay_status = 0;
        $data->save();
        if($data->update()){
            return response()->json(['status'=>'success']);
        }
        return response()->json(['status'=>'fail']);

    }


    public function destroy($id)
    {
        $benefit = AdditionlBenifitsSpending::findOrFail($id);
        if ($benefit->delete() == 1) {
            $success = true;
            $message = "Journal deleted successfully";
        }
        else {
            $success = false;
            $message = "journal not found";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    
}
