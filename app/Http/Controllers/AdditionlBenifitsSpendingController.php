<?php

namespace App\Http\Controllers;

use App\AdditionlBenifitsSpending;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdditionlBenifitsSpendingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        $activeMenu = 'benefits';
        $data = AdditionlBenifitsSpending::get();

        return view('additional-benifits-spending.index', compact('activeMenu', 'data'));
    }

    /**
     * Filter pending additional benefits spending.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchPending (Request $request)
    {
        $data = $this->searchAdditionalBenefits('pending_date', $isPending = true);

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('additionl_benifits_spendings.edit', $datum->id);
                $routes['update'] = route('additionl_benifits_spendings.update', $datum->id);
                $routes['approve'] = route('additionl_benifits_spendings.approve', $datum->id);
                $routes['reject'] = route('additionl_benifits_spendings.reject', $datum->id);
                $routes['paid'] = route('additionl_benifits_spendings.paid', $datum->id);
                $routes['non-paid'] = route('additionl_benifits_spendings.non-paid', $datum->id);
                $routes['destroy'] = route('additionl_benifits_spendings.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Filter historical additional benefits spending.
     * @param string $searchField
     * @param bool $isPending
     * @return Response
     */
    private function searchAdditionalBenefits ($searchField, $isPending = true)
    {
        $query = AdditionlBenifitsSpending::orderByDesc('date');
        $query->dateSearch('date');
        // $query->isEmployee();

        // pending has not status
        if ($isPending) {
            $query->whereNull('status');
        } else {
            $query->whereNotNull('status');
        }
        return $query->get();
    }

    /**
     * Filter historical additional benefits spending.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchHistory (Request $request)
    {
        $data = $this->searchAdditionalBenefits('history_date', false);

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('additionl_benifits_spendings.edit', $datum->id);
                $routes['update'] = route('additionl_benifits_spendings.update', $datum->id);
                $routes['approve'] = route('additionl_benifits_spendings.approve', $datum->id);
                $routes['reject'] = route('additionl_benifits_spendings.reject', $datum->id);
                $routes['paid'] = route('additionl_benifits_spendings.paid', $datum->id);
                $routes['nonPaid'] = route('additionl_benifits_spendings.non-paid', $datum->id);
                $routes['destroy'] = route('additionl_benifits_spendings.destroy', $datum->id);
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
     * @param int $id
     * @return void
     */
    public function show ($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function edit (AdditionlBenifitsSpending $additionlBenifitsSpending)
    {
        $data = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
        if ($data) {
            return response()->json(['status' => 'success', 'data' => $data]);
        }
        return response()->json(['status' => 'fail']);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update (Request $request, AdditionlBenifitsSpending $additionlBenifitsSpending)
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
            $data = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
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
     * Change the resource status approve.
     * @param int $id
     * @return JsonResponse
     */
    public function approve (AdditionlBenifitsSpending $additionlBenifitsSpending)
    {
        $data = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
        $data->status = 1;
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);

    }

    /**
     * Change the resource status reject.
     * @param int $id
     * @return JsonResponse
     */
    public function reject (AdditionlBenifitsSpending $additionlBenifitsSpending)
    {
        $data = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
        $data->status = 2;
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);

    }

    /**
     * Change the resource status paid.
     * @param int $id
     * @return JsonResponse
     */
    public function paid (AdditionlBenifitsSpending $additionlBenifitsSpending)
    {
        $data = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
        $data->pay_status = 1;
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);

    }

    /**
     * Change the resource status non paid.
     * @param int $id
     * @return JsonResponse
     */
    public function nonPaid (AdditionlBenifitsSpending $additionlBenifitsSpending)
    {
        $data = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
        $data->pay_status = 0;
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'fail']);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy (AdditionlBenifitsSpending $additionlBenifitsSpending)
    {
        $benefit = AdditionlBenifitsSpending::findOrFail($additionlBenifitsSpending->id);
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
