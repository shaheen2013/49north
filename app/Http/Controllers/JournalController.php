<?php

namespace App\Http\Controllers;

use App\Journal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        $data = Journal::get();
        $activeMenu = 'classroom';
        // return $data;
        // return response()->json(['status'=>'success', 'data'=>$data]);
        return view('journal.index', compact('activeMenu'))->with('data', $data);
    }

    /**
     * Filter journal.
     * @param string $searchField
     * @return Response
     */
    private function journalSearch ($searchField)
    {
        $query = Journal::orderByDesc('date');
        $query->dateSearch('date');
        // $query->isEmployee();
        return $query->get();
    }

    /**
     * Filter journal.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchJournal (Request $request)
    {

        $data = $this->journalSearch('search');
        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('journal.edit', $datum->id);
                $routes['update'] = route('journal.update', $datum->id);
                $routes['destroy'] = route('journal.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create ()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request)
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
     * @param Journal $journal
     * @return void
     */
    public function show (Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit ($id)
    {
        $data = Journal::findOrFail($id);
        if ($data) {
            return response()->json(['status' => 'success', 'data' => $data]);
        }
        return response()->json(['status' => 'fail']);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update (Request $request, $id)
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
     * @param $id
     * @return JsonResponse
     */
    public function destroy ($id)
    {
        $journal = Journal::findOrFail($id);
        if ($journal->delete() == 1) {
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
