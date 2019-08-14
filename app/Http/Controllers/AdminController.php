<?php

namespace App\Http\Controllers;

use App\Cases;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admins.index');
    }

    /*
     * list of admin
     */
    public function adminlist()
    {
        return view('admins.admin');
    }

    /*
     * Case create
     */

    public function create()
    {
        return view('admins.create');
    }

    /*
     * Save admin
     */

    public function store(Request $request)
    {


        /*$model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->alternate_email = $request->input('alternate_email');
        $model->contact_number = $request->input('contact_number');
        $model->company = $request->input('company');
        $model->password = Hash::make($request->input('password'));
        $model->email_enabled = ($request->input('email_enabled') ? 1 : 0);
        $model->whatsapp_enabled = ($request->input('whatsapp_enabled') ? 1 : 0);
        $model->created_at = Carbon::now()->format('Y-m-d H:i:s');*/
        if ($request->input('role') == 'admin'){
            $role = 'admin';
        }else{
            $role = 'user';
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'alternate_email' => $request->input('alternate_email'),
            'contact_number' => $request->input('contact_number'),
            'company' => $request->input('company'),
            'password' => Hash::make($request->input('password')),
            'email_enabled' => ($request->input('email_enabled') ? 1 : 0),
            'whatsapp_enabled' => ($request->input('whatsapp_enabled') ? 1 : 0),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),

        ])->assignRole($role);


        return redirect('/admin/adminlist');


    }

    /*
     * update case
     */

    public function update(Request $request, User $user)
    {
        if ($request->isMethod('post')) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->alternate_email = $request->input('alternate_email');
            $user->contact_number = $request->input('contact_number');
            $user->company = $request->input('company');
            $user->email_enabled = ($request->input('email_enabled') ? 1 : 0);
            $user->whatsapp_enabled = ($request->input('whatsapp_enabled') ? 1 : 0);
            $user->updated_at = Carbon::now()->format('Y-m-d H:i:s');


            if ($user->save()){
                return redirect('/admin/adminlist');
            }
        }

        return view('admins.update', ['user' => $user]);
    }

    public function view(Request $request, User $user){
            return view('admins.view', ['user' => $user]);
    }

    public function delete(Request $request){
        User::find($request->input('id'))->delete();
        return response()->json([
            'token' => 1
        ]);
    }

    public function updatepass(Request $request, User $user){
        return view('admins.updatepass', ['user' => $user]);
    }

    public function updatepassword(Request $request, User $user){
        $user->password = Hash::make($request->input('newpassword'));
        $user->save();
        Session::flash('message', "Password changed successfully");
        return redirect('/update/password/'.$user->id);
    }
}
