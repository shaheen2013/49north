<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use App\Employee_detail;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        //Get all users and pass it to the view
      $users = User::all();
/*\DB::connection()->enableQueryLog();
$users = Employee_detail::Join('Users', 'users.id', '=', 'employee_details.emp_id') 
    ->get();
 $queries = \DB::getQueryLog();
         dd($queries);*/
/*$data['users'] = DB::table('users as u')
    ->select('ed.*','u.created_at as createdat')
    ->join('employee_details as ed', 'u.id', '=', 'ed.emp_id')
    ->get();*/
    
       return view('users.index',)->with('users', $users);
    //return view('users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        //Get all roles and pass it to the view
        $user = new User();
        return view('users.edit', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $id = $request->input('id');


        //Validate name, email and password fields
        $rules = [
            'name' => 'required|max:120'
        ];
        $rules['email'][] = Rule::unique('users')->ignore($id);
        $input = $request->only(['email', 'name']);

        // if password is entered or it's a new user
        if ($request->input('password') || !$id) {
            //$rules['password'] = 'required|min:6|confirmed';
            $rules['password'] = ['required', 'string', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'];
            $input['password'] = Hash::make($request->input('password'));
        }

        $this->validate($request, $rules);

        $input['is_admin'] = $request->input('is_admin', 0);
         

        //profile pic  code
         $profilepicname = '';
        if ($request->hasFile('profile_pic')) {

            $file = $request->file('profile_pic');
            $profilepicname = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $request->file('profile_pic')->move("public/profile", $name);
        } 
        /// end profile pic

          // employee details array start  
        $user_array = $request->except(['password','is_admin']);
            $user_array['profile_pic'] = $profilepicname;

        if ($id) {
            $user = User::find($id);
            $user->update($input);
            
            $user_detailsupdate = Employee_detail::find($id);
            $user_detailsupdate->update($user_array);
            $msg = 'User successfully updated';
        } else {
            $user = User::create($input);
            $lastid = $user->id;
            
            $user_array['emp_id'] = $lastid;
            $user_details = Employee_detail::create($user_array);
            $msg = 'User successfully Added';
        }

        //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('flash_message', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function show($id)
    {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles

        return view('users.edit', compact('user', 'roles')); //pass user and roles data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); //Get role specified by id

        //Validate name, email and password fields
        $this->validate($request, [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:6|confirmed'
        ]);
        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();


        return redirect()->route('users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($id)
    {
        //Find a user with a given id and delete
        $user = User::find($id);
        $success = $user->exists ? true : false;
        $user->delete();

        return response()->json(['success' => $success]);
    }
}
