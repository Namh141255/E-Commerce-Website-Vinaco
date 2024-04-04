<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo"<pre>"; print_r($data); die;

            //validation
            $rules = [
                'email'=> 'required|email|max:255',
                'password'=> 'required|max:30'
            ];

            $customMessages = [
                'email.required'=> "Email is required",
                'email.email' => "Valid Email is required",
                'password.required'=> "Password is required"
            ];

            $this->validate($request, $rules, $customMessages );

            if(Auth::guard('admin')->attempt(['email'=> $data['email'],'password'=> $data['password']])){
                return redirect("admin/dashboard");
            }else{
                return redirect()->back()->with("error_message","Invalid Email or Password!");
            }
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // Check if current password is correct 
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
                //Check if new password and confirm password are matching
                if($data['new_pwd']==$data['confirm_pwd']){
                    //Update new password
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=> bcrypt($data['new_pwd'])]);
                    return redirect()->back()->with('success_message','Password has been updated Successfully!');
                }else{
                    return redirect()->back()->with('error_message','New password and Retype password not match!');
                }
            }else{
                return redirect()->back()->with('error_message','Your current password is Incorrect!');
            }
        }
        return view('admin.update_password');
    }

    public function checkCurrentPassword(Request $request){
        $data = $request->all();
        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            // echo"<pre>"; print_r($data); die;

            //validation
            $rules = [
                'admin_name'=> 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'admin_mobile'=> 'required|numeric|digits:10'
            ];

            $customMessages = [
                'admin_name.required'=> "Name is required",
                'admin_name.regex'=> "Valid Name is required",
                'admin_name.max'=> "Valid Name is required",
                'admin_mobile.required'=> "Mobile is required",
                'admin_mobile.numeric'=> "Valid mobile is required",
                'admin_mobile.digits'=> "Valid mobile is required",
            ];

            $this->validate($request, $rules, $customMessages );

            //Update Admin Details
            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=> $data['admin_name'],
            'mobile'=> $data['admin_mobile']]);
            return redirect()->back()->with('success_message','Admin Details has been updated Successfully!');
        }
        return view("admin.update_details");
    }
}
