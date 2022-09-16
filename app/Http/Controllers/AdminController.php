<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Owner;
use App\Models\User;

class AdminController extends Controller
{

    public function admin_dashboard()
    {
        return view('admin.pages.dashboard');
    }



    public function admin_login()
    {
        return view('admin.auth.login');
    }

    public function post_admin_login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $email_check=Admin::where('email',$request->email)->get()->count();

        if($email_check){

            $pass_check=Admin::where('email',$request->email)->get();
            if($pass_check[0]->password==$request->password){
                session()->put('adminId',$pass_check[0]->id);
                return redirect('admin-dashboard');
            }
            else{
                \Session::put('failed','Invalid password!');
                return back();
            }

        }
        else{

            \Session::put('failed','Invalid email address!');
            return back();

        }
    }

    public function admin_logout()
    {
        session()->forget('adminId');
        return redirect('admin-login');
    }

    public function machine_owners()
    {
        $owners=Owner::orderBy('id','desc')->get();
        return view('admin.pages.machine_owner.index',compact('owners'));
    }

    public function users()
    {
        $users=User::orderBy('id','desc')->get();
        return view('admin.pages.users.index',compact('users'));
    }
}
