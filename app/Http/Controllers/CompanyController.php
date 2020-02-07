<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\{Company, Project, Purchases, Categorys, Expenses};
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index ()
    {
        if (auth()->user()->is_admin == 1) {
            $activeMenu = 'company';
            return view('company.company-report', compact('activeMenu'));
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create ()
    {
        if (auth()->user()->is_admin == 1) {
            $data = null;
            if ($data) {
                return response()->json(['status' => 'success', 'data' => $data]);
            }
            return response()->json(['status' => 'fail']);
        } else {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request)
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
    public function edit ($id)
    {
        if (auth()->user()->is_admin == 1) {
            $data = Company::findOrFail($id);
            if ($data) {
                return response()->json(['status' => 'success', 'data' => $data]);
            }
            return response()->json(['status' => 'fail']);
        } else {
            abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update (Request $request, $id)
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

    /**
     * Filter Company.
     * @param Request $request
     * @return JsonResponse
     */
    public function searchCompanyPage (Request $request)
    {
        $data = Company::where(function ($q) use ($request) {
            if (isset($request->search)) {
                $q->where('companyname', 'LIKE', '%' . $request->search . '%');
            }
        });
        $data = $data->orderBy('companyname', 'asc')->get();

        if (count($data)) {
            foreach ($data as $datum) {
                $routes = [];
                $routes['edit'] = route('company.edit', $datum->id);
                $routes['update'] = route('company.update', $datum->id);
                $routes['destroy'] = route('company.destroy', $datum->id);
                $datum->routes = $routes;
            }
        }
        return response()->json(['status' => 'success', 'data' => $data]);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy ($id)
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
