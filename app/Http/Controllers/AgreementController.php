<?php

namespace App\Http\Controllers;

use App\{Agreement, Codeofconduct, Employee_detail};
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\View\View;

class AgreementController extends Controller {

    /**
     * @return Factory|View
     */
    function agreementlist()
    {
        $activeMenu = 'profile';
        $q = Employee_detail::orderBy('firstname')->with('activeAgreement', 'activeCodeofconduct', 'activeAgreement.amendments');

        /// if employee is not admin
        if (auth()->user()->is_admin == 0) {
            $q->where('id', auth()->user()->id);
        }
        $users = $q->get();

        return view('agreement_listnew', compact('users', 'activeMenu'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    function addagreement (Request $request) {
        //$file = $request->file('agreement_file');
        //$name = str_pad($request->input('employee_id'), '3', '0', STR_PAD_LEFT) . '-' . rand(11111, 99999) . '.' . $file->getClientOriginalExtension();

        $conditions = ['emp_id' => $request->input('employee_id'), 'status' => 'A'];

        // get file upload type
        $type = $request->input('agreement_type') == 'EA' ? : 'COC';
        // set file directory for upload
        $path = $type == 'EA' ? 'agreement' : 'codeofconduct';

        try {
            $name = fileUpload('agreement_file', true);
            //$request->file('agreement_file')->move("public/" . $path, $name);
        } catch (Exception $e) {
            return redirect()->back()->with('message', 'File not saved');
        }

        if ($type == 'EA') {
            // if it is an amendment, then attach it to an agreement
            if ($request->input('is_amendment', false)) {
                $currentAgreement = Agreement::where($conditions)->first();
                Agreement::create([
                    'emp_id'    => $request->employee_id,
                    'agreement' => $name,
                    'parent_id' => $currentAgreement['id']
                ]);

                $msg = 'Agreement added successfully';
            }
            else {
                // set old agreement, if it exists, to "D"
                Agreement::where($conditions)->update(['status' => 'D']);
                Agreement::create([
                    'emp_id'    => $request->employee_id,
                    'agreement' => $name
                ]);

                $msg = 'Agreement updated successfully';
            }
        }
        elseif ($type == 'COC') {
            // set old agreement, if it exists, to "D"
            Codeofconduct::where($conditions)->update(['status' => 'D']);

            Codeofconduct::create([
                'emp_id'        => $request->employee_id,
                'coc_agreement' => $name,
            ]);

            $msg = 'Code of conduct updated successfully';
        }

        //return redirect()->back();
        return redirect()->back()->with('alert-info', $msg);
    }

    /**
     * @param $id
     * @param $type
     *
     * @return JsonResponse
     */
    function destroy ($id, $type) {

        if ($type == 'EA') {
            $agreement = Agreement::where('id', $id)->first();
        }
        else {
            $agreement = Codeofconduct::where('id', $id)->first();
        }

        $agreement->delete();

        return response()->json([
            'success' => 'Agreement deleted successfully!'
        ]);
    }

    /**
     * Filter agreement
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search (Request $request) {
        try {

            $q = Employee_detail::latest()->with('activeAgreement', 'activeCodeofconduct', 'activeAgreement.amendments');

            if (!auth()->user()->is_admin) {
                $q->where('id', auth()->user()->id);
            }

            if ($search = $request->input('search')) {
                $q->where(DB::raw("CONCAT(firstname, ' ', lastname)"), 'like', '%' . $search . '%');
            }
            $data = $q->get();

            foreach ($data as $datum) {
                if ($datum->activeAgreement) {
                    $datum->active_agreement_url = fileUrl($datum->activeAgreement->agreement, true);

                    if (count($datum->activeAgreement->amendments)) {
                        foreach ($datum->activeAgreement->amendments as $amendment) {
                            $amendment->amendment_url = fileUrl($amendment->agreement, true);
                        }
                    }
                }

                if ($datum->activeCodeofconduct) {
                    $datum->active_code_of_conduct_url = fileUrl($datum->activeCodeofconduct->coc_agreement, true);
                }
            }

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
