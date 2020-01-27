<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Get all resources
        $activeMenu = 'benefits';
        $plan = Plan::Latest()->where('status', 1)->first();

        return view('plan.index', compact('activeMenu', 'plan'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        // Create new model instance
        $plan = new Plan();
        $plan->file = fileUpload('file');
        $plan->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Plan $plan)
    {
        // Validate form data
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        Plan::where('status', 1)
            ->update(['status' => 0]);

        // Create new model instance
        $plan = new Plan();
        $plan->file = fileUpload('file');
        $plan->save();

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Plan $plan)
    {

    }
}
