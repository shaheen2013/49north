<?php

namespace App\Http\Controllers;


use App\{PersonalDevelopmentPlan, Employee_detail, User};
use Illuminate\Http\Request;

class PersonalDevelopmentPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeMenu = 'classroom';
        $data = PersonalDevelopmentPlan::get();
        $user = User::get();
        return view('personal-development-plan.index', compact('data', 'user', 'activeMenu'));
    }

    private function _searchArchive($searchField)
    {
        $query = PersonalDevelopmentPlan::orderByDesc('start_date');
        $query->dateSearch('start_date');
        // $query->isEmployee();
        return $query->get();
    }

    public function searchArchive(Request $request)
    {

        $data = $this->_searchArchive('search');

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:191',
            'description' => 'required|string|max:491',
            'start_date' => 'required',
            'end_date' => 'required',
            // 'comment' => 'string|max:491',

        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = $request->all();

            $check = PersonalDevelopmentPlan::create($data);

            if ($check) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }

    public function commentStore(Request $request, $id)
    {

        // Validate form data
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = PersonalDevelopmentPlan::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->save()) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }

    }

    public function commentUpdate(Request $request, $id)
    {

        // Validate form data
        $rules = [
            'comment' => 'string|max:491',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            // return $request->all();
            $data = PersonalDevelopmentPlan::findOrFail($id);
            $data->comment = $request->comment;

            if ($data->update()) {
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
     * @param \App\PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activeMenu = 'classroom';
        // $user = PersonalDevelopmentPlan::with('employee')->first();
       
        $show = PersonalDevelopmentPlan::find($id);
        return view('personal-development-plan.show', compact('show', 'user', 'activeMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PersonalDevelopmentPlan::findOrFail($id)->first();
        $data['user'] = User::get();
        if ($data) {
            return response()->json(['status' => 'success', 'data' => $data]);
        }
        return response()->json(['status' => 'fail']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PersonalDevelopmentPlan $personalDevelopmentPlan
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
            $data = PersonalDevelopmentPlan::findOrFail($id);
            $data->emp_id = $request->emp_id;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_date = $request->start_date;
            $data->end_date = $request->end_date;
            // $data->comment = $request->comment;

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
     * @param \App\PersonalDevelopmentPlan $personalDevelopmentPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $benefit = PersonalDevelopmentPlan::findOrFail($id);
        if ($benefit->delete() == 1) {
            $success = true;
            $message = "Journal deleted successfully";
        } else {
            $success = false;
            $message = "journal not found";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
