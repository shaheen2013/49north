<?php

namespace App\Http\Controllers;

use App\{Company, Mail\ExpenseCreated, Project, Purchases, Categorys, Expenses};
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\{Mail, Storage};
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    function index()
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

        $data['companies'] = Company::all();
        $data['project'] = Project::all();
        $data['purchases'] = Purchases::all();
        $data['category'] = Categorys::all();
        $data['expense'] = Expenses::where(['delete_status' => NULL, 'status' => NULL])->get();

        return view('expense.expensereport', $data, compact('activeMenu'));
    }

    /**
     * Filter historical expense.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchHistory(Request $request)
    {
        $data = Expenses::orderByDesc('created_at')->with('employee:id,firstname,lastname')->where('status', '!=', null)
            ->where(function ($q) use ($request) {
                if (isset($request->history_search)) {
                    $q->whereHas('employee', function ($sql) use ($request) {
                        $sql->where(\DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', '%' . $request->history_search . '%');
                        $sql->orWhere('description', 'LIKE', '%' . $request->history_search . '%');
                    });
                }
            });

        $data = $data->dateSearch('date');
        $data = $data->isEmployee()->get();

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('expenses.edit', $datum->id);
                $routes['update'] = route('expenses.update', $datum->id);
                $routes['approve'] = route('expenses.approve', $datum->id);
                $routes['reject'] = route('expenses.reject', $datum->id);
                $routes['destroy'] = route('expenses.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Filter pending expense.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchPending(Request $request)
    {
        $data = Expenses::orderByDesc('created_at')->with('employee:id,firstname,lastname')->where('status', null)
            ->where(function ($q) use ($request) {
                if (isset($request->pending_search)) {
                    $q->whereHas('employee', function ($sql) use ($request) {
                        $sql->where(\DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', '%' . $request->pending_search . '%');
                        $sql->orWhere('description', 'LIKE', '%' . $request->pending_search . '%');
                    });
                }
            });

        $data = $data->dateSearch('date');
        $data = $data->isEmployee()->get();

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('expenses.edit', $datum->id);
                $routes['update'] = route('expenses.update', $datum->id);
                $routes['approve'] = route('expenses.approve', $datum->id);
                $routes['reject'] = route('expenses.reject', $datum->id);
                $routes['destroy'] = route('expenses.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return JsonResponse
     */
    public function edit(Expenses $expense)
    {
        $data['expense'] = Expenses::findOrFail($expense->id);
        $data['companies'] = Company::all();
        $data['project'] = Project::all();
        $data['purchases'] = Purchases::all();
        $data['category'] = Categorys::all();

        if ($data) {
            return response()->json(['status' => 'success', 'data' => $data]);
        }
        return response()->json(['status' => 'fail']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, Expenses $expense)
    {
        // Validate form data
        $rules = [
            'receipt' => 'nullable|file|mimes:pdf,doc,docx',
            'company' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
            'total' => 'required|regex:/^\d+(\.\d{1,5})?$/',
        ];

        $validator = validator($request->all(), $rules, []);

        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'errors' => $validator->getMessageBag()->toarray()]);
        }

        try {
            $data = Expenses::findOrFail($expense->id);
            $receipt = null;

            if ($request->hasFile('receipt')) {
                Storage::delete($data->receipt);
                $data->receipt = fileUpload('receipt');
            }

            $data->company = $request->company;
            $data->category = $request->category;
            $data->purchase = $request->purchase;
            $data->project = $request->project;
            $data->description = $request->description;
            $data->date = $request->date;
            $data->billable = $request->billable;
            $data->received_auth = $request->received_auth;
            $data->subtotal = $request->subtotal;
            $data->gst = $request->gst;
            $data->pst = $request->pst;
            $data->total = $request->total;

            if ($data->update()) {
                $company = Company::findOrFail($request->company);

                if ($company) {
                    Mail::to($company->email)->send(new ExpenseCreated($data, true));
                }

                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'fail']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'fail', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Expenses $expense)
    {
        $expense = Expenses::findOrFail($expense->id);
        if ($expense->delete() == 1) {
            $success = true;
            $message = "Expense deleted successfully";
        } else {
            $success = false;
            $message = "Expense not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    function store(Request $request)
    {
        $request->validate([
            'receipt' => 'nullable|file|mimes:pdf,doc,docx',
            'company' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
            'total' => 'required|regex:/^\d+(\.\d{1,5})?$/',
        ]);

        $data = $request->all();

        if ($request->hasFile('receipt')) {
            $data['receipt'] = fileUpload('receipt');
        }

        $expense = Expenses::create($data);
        $msg = "Expense added successfully";
        $company = Company::findOrFail($request->company);

        if ($company) {
            Mail::to($company->email)->send(new ExpenseCreated($expense, false));
        }

        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * Change the resource status approve.
     * @param int $id
     * @return JsonResponse
     */
    public function approve(Expenses $expense)
    {
        $data = Expenses::findOrFail($expense->id);
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
    public function reject(Expenses $expense)
    {
        $data = Expenses::findOrFail($expense->id);
        $data->status = 2;
        $data->save();
        if ($data->update()) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail']);
    }
}
