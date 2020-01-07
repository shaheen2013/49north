<?php

namespace App\Http\Controllers;

use App\{Agreement, Codeofconduct, Employee_detail};
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\View\View;

class AgreementController extends Controller {

    /**
     * @return Factory|View
     */
    function agreementlist () {
        $q = Employee_detail::orderBy('firstname')->with('activeAgreement', 'activeCodeofconduct', 'activeAgreement.amendments');

        /// if employee is not admin
        if (auth()->user()->is_admin == 0) {
            $q->where('id', auth()->user()->id);
        }
        $users = $q->get();

        return view('agreement_listnew', compact('users'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    function addagreement (Request $request) {

        $file = $request->file('agreement_file');
        $name = str_pad($request->input('employee_id'), '3', '0', STR_PAD_LEFT) . '-' . rand(11111, 99999) . '.' . $file->getClientOriginalExtension();

        $conditions = ['emp_id' => $request->input('employee_id'), 'status' => 'A'];

        // get file upload type
        $type = $request->input('agreement_type') == 'EA' ? : 'COC';
        // set file directory for upload
        $path = $type == 'EA' ? 'agreement' : 'codeofconduct';

        try {
            $request->file('agreement_file')->move("public/" . $path, $name);
        } catch (Exception $e) {
            return redirect()->back()->with('message','File not saved');
        }

        if ($type == 'EA') {
            // if it is an amendment, then attach it to an agreement
            if ($request->input('is_amendment', false)) {
                $currentAgreement = Agreement::where($conditions)->first();
                Agreement::create([
                    'emp_id'    => $request->employee_id,
                    'agreement' => $name,
                    'parent_id' => $currentAgreement->id
                ]);
            }
            else {
                // set old agreement, if it exists, to "D"
                Agreement::where($conditions)->update(['status' => 'D']);
                Agreement::create([
                    'emp_id'    => $request->employee_id,
                    'agreement' => $name
                ]);
            }
        }
        elseif ($type == 'COC') {
            // set old agreement, if it exists, to "D"
            Codeofconduct::where($conditions)->update(['status' => 'D']);

            Codeofconduct::create([
                'emp_id'        => $request->employee_id,
                'coc_agreement' => $name,
            ]);
        }

        return redirect()->back();
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

}
