<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee_detail;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\{Auth,Hash};
use Illuminate\Validation\{Rule,ValidationException};
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index () {
        //Get all users and pass it to the view
        $users = User::with('employee_details')->orderBy('name')->get();

        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create () {
        //Get all roles and pass it to the view
        $user = new User();

        return view('users.edit', compact('user'));
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes () {
        return [
            'password' => 'Password must contain a lower case, uppercase, number and special character',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store (Request $request) {
        $id = $request->input('id');

        //Validate name, email and password fields
        $rules = [
            'firstname' => 'required|max:120',
            'lastname'  => 'required|max:120',
            'email'     => Rule::unique('users')->ignore($id) // require unique email address
        ];

        // morph input fields to match user table
        $input['name'] = $request->input('firstname') . ' ' . $request->input('lastname');
        $input['email'] = $request->input('workemail');

        // if password is entered or it's a new user
        if ($request->input('password') || !$id) {
            //$rules['password'] = 'required|min:6|confirmed';
            $rules['password'] = ['required', 'string', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'];
            $input['password'] = Hash::make($request->input('password'));
        }

        $this->validate($request, $rules);

        // check for admin details
        $input['is_admin'] = $request->input('is_admin', 0);

        //profile pic  code
        $profilepicname = '';
        if ($request->hasFile('profile_pic')) {

            $file = $request->file('profile_pic');
            $profilepicname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('profile_pic')->move("public/profile");
        }
        /// end profile pic

        // employee details array start
        $user_array = $request->only([
            'firstname',
            'lastname',
            'dob',
            'personalemail',
            'phone_no',
            'address',
            'workemail',
            'profile_pic',
            'marital_status',
            'no_ofchildren',
            'family_inarea',
            'spcifamilycircumstace',
            'prsnl_belief',
            'known_medical_conditions',
            'allergies',
            'dietary_restrictions',
            'known_health_concerns',
            'aversion_phyactivity',
            'emergency_contact_name',
            'reltn_emergency_contact',
            'emergency_contact_phone',
            'emergency_contact_email'
        ]);
        $user_array['profile_pic'] = $profilepicname;

        if ($id) {
            $user = User::find($id);
            $user->update($input);
            $emp_id = $id;
            /*            $user_detailsupdate = Employee_detail::find($id);
                        $user_detailsupdate->update($user_array);*/
            $msg = 'User successfully updated';
        }
        else {
            $user = User::create($input);

            $msg = 'User successfully Added';
        }

        if (isset($emp_id)) {
            //$user->employee_details()->update($user_array);
            Employee_detail::where('id', '=', $emp_id)->update($user_array);
        }
        else {
            $user->employee_details()->create($user_array);

        }

        //Redirect to the users.index view and display message
        return redirect()->route('users.index')->with('alert-info', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return RedirectResponse|Redirector
     */
    public function show ($id) {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Factory|View
     */
    public function edit ($id) {
        $u = User::findOrFail($id); //Get user with specified id
        //DB::enableQueryLog();
        $user = Employee_detail::find($u->id);
        /* $query = DB::getQueryLog();
         print_r($query);
         die;*/
        if (!$user) {
            $user = new Employee_detail();
            // separate first / last name from user table
            [$user->firstname, $user->lastname] = explode(' ', $u->name);
            $user->workemail = $u->email;
        }

        if (!$user->workemail) {
            $user->workemail = $u->email;
        }
        $user->is_admin = $u->is_admin; // lazy load details from admin
        $user->id = $u->id; // override ID to match User table instead of Employee Details

        return view('users.edit', compact('user'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse|RedirectResponse
     */
    public function destroy ($id) {
        //Find a user with a given id and delete
        $user = User::find($id);
        $success = $user->exists ? true : false;
        $user->delete();

        return response()->json(['success' => $success]);
    }

    /**
     * @param User $user
     *
     * @return RedirectResponse
     */
    public function forceLogin (User $user) {
        // only allow forced login when user is an admin
        if (Auth::user()->user_role == 'admin' && !request()->input('return')) {
            session(['was-admin-id' => Auth::user()->id, 'was-admin' => Auth::user()->remember_token]);
            Auth::loginUsingId($user->id);
        }
        elseif (session('was-admin-id') == $user->id && session('was-admin') == $user->remember_token) {
            session()->forget(['was-admin', 'was-admin-id']);
            Auth::loginUsingId($user->id);
        }
        else {
            return redirect()->back();
        }

        return redirect()->route('home');
    }

}
