<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Jobs\MailJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::all();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['user'] = new User(); 
        $data['roles'] = Role::all();
        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'role' => 'required',
            'email' => $request->has('user_id') ? 'nullable' : 'required|email|unique:users',
            'phone' => 'nullable|digits:10|unique:users,phone,'.Helper::decodeId($request->user_id),
            'password' => $request->has('user_id') ? 'nullable' : 'required'
        ]);

        try {
             
            $input = $request->all();
            
            // update password only when entered by user else unset the empty password
            if($request->password != '')
                $input['password'] = Hash::make($request->password);
            else 
                unset($input['password']);

            $user = User::updateOrCreate([
                'id' => Helper::decodeId($request->user_id)
            ], $input);
            
            $user = User::find($user->id);

            foreach ($request->role as $value) {
                $user->assignRole($value);
            }

            // $details = [
            //     "subject" => "Welcome to ". env('APP_NAME') . $user->name,
            //     "job" => 'WelcomeUserMail',
            //     "to" => $user->email,
            //     'name' => $user->name,
            //     'password' => $request->password,
            //     'url' => url('')
            // ];

            // // send only when new account is created
            // if(!$request->has('user_id'))
            //     dispatch(new MailJob($details));

            return redirect()->back()->with('success', $request->has('user_id') ? 'User Updated Successfully' : 'User Created Successfully'); 

        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data['user'] = User::find(Helper::decodeId($request->user));
        $data['roles'] = Role::all();
        return view('admin.user.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('id', Helper::decodeId($request->user))->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully'); 
    }
}
