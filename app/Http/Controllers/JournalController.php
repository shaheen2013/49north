<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data= Journal::get();
        $activeMenu = 'classroom';
        // return $data;
        // return response()->json(['status'=>'success', 'data'=>$data]);
        return view('journal.index', compact('activeMenu'))->with('data', $data);
    }

    private function _searchJournal ($searchField) {
        $query = Journal::orderByDesc('date');
        $query->dateSearch('date');
        // $query->isEmployee();
        return $query->get();
    }

    public function searchJournal (Request $request) {

        $data = $this->_searchJournal('search');

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
            'title' => 'required|string|max:191',
            'details' => 'required|string|max:491',

        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = $request->all();

            $check = Journal::create($data);

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
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Journal::findOrFail($id)->first();
        if($data){
            return response()->json(['status'=>'success', 'data'=>$data]);
        }
        return response()->json(['status'=>'fail']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // Validate form data
       $rules = [
        'date' => 'required',
        'title' => 'required|string|max:191',
        'details' => 'required|string|max:491',
    ];

    $validator = validator($request->all(), $rules, []);

    if ($validator->fails()) {
        return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
    }

    try {
        // return $request->all();
        $data = Journal::findOrFail($id);
        $data->date = $request->date;
        $data->title = $request->title;
        $data->details = $request->details;

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
     * @param  \App\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        if ($journal->delete() == 1) {
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
