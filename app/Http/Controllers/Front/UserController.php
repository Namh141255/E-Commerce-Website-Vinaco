<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function loginUser(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";print_r($data); die;

            $validator = Validator::make($request->all(),[
                'email' => 'required|email|max:250|exists:users',
                'password' => 'required|min:6'
                ],
                [
                    'email.required' => 'Email is required',
                    'email.email' => 'Please enter the valid Email',
                    'email.max' => 'Please enter the valid Email',
                    'emali.exists' => 'Email already does not exists',
                    'password.required' => 'Password is required',
                    'password.min' => 'Password is too short',
                ]
            );

            if($validator->passes()){
                if(Auth::attempt(['email'=>$data['email'],'password' => $data['password']])){

                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['status'=>false,'type'=>'inactive','message'=>'Your account has been suspended!']);
                    }
                    $redirectUrl = url('cart');
                    return response()->json(['status'=>true,'type'=>'success','redirectUrl'=>$redirectUrl]);
                }else{
                    return response()->json(['status'=>false,'type'=>'incorrect','message'=>'Wrong Email or Password!']);
                }
            }else{
                return response()->json(['status'=>false,'type'=>'error','errors'=>$validator->messages()]);
            }
        }
        return view('front.users.login');
    }

    public function registerUser(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:150',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email|max:250|unique:users',
                'password' => 'required|string|min:6'
                ],
                [
                    'name.required' => 'Name is required',
                    'name.string' => 'Please enter the valid Name',
                    'name.max' => 'Please enter the valid Name',
                    'mobile.required' => 'Mobile is required',
                    'mobile.numeric' => 'Please enter the valid Mobile',
                    'mobile.digits' => 'Please enter the valid Mobile',
                    'email.required' => 'Email is required',
                    'email.email' => 'Please enter the valid Email',
                    'email.max' => 'Please enter the valid Email',
                    'emali.unique' => 'Email already exists',
                    'emai.email' => 'Please enter the valid Email',
                    'password.required' => 'Password is required',
                    'password.string' => 'Please enter the valid Password',
                    'password.min' => 'Password is too short',
                ]
            );

            if($validator->passes()){
                $data = $request->all();
                // echo "<pre>";print_r($data); die;

                //Register the User 
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();

                if(Auth::attempt(['email'=>$data['email'],'password' => $data['password']])){
                    $redirectUrl = url('cart');
                    return response()->json(['status'=>true,'type'=>'success','redirectUrl'=>$redirectUrl]);
                }
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
        return view('front.users.register');
    }

    public function logoutUser(Request $request){
        Auth::logout();
        return redirect('user/login');
    }

    public function account(Request $request){        

        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>";print_r($data); die;

            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:150',
                'city' => 'required|string|max:150',
                'state' => 'required|string|max:150',
                'address' => 'required|string|max:150',
                'country' => 'required|string|max:150',
                'pincode' => 'required|string|max:150',
                'mobile' => 'required|numeric|digits:10'
                ]);

            if($validator->passes()){
               //Update User Details
               User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'address'=>$data['address'],'city'=>$data['city'],'state'=>$data['state'],'country'=>$data['country'],'pincode'=>$data['pincode'],'mobile'=>$data['mobile']]);
               
                return response()->json(['status'=> true,'type'=>'success','message'=>"User Details Successfully updated!"]);
            }else{
                return response()->json(['status'=> false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.account');
        }
        
    }
}
