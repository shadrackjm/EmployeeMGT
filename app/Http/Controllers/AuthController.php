<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //here load a registration form
    public function loadRegisterForm(){
        return view("register-form");
    }

    public function registerUser(Request $request){
        // perform validation here
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:8|confirmed',
        ]);
        // then if validation is successfully bypassed register user
        // put the whole logic in a try and catch block
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 2;
            $user->password = Hash::make( $request->password );
            $user->save();
            return redirect('/registration/form')->with('success','You Have been Registered Successfully!');
        } catch (\Exception $e) {
            return redirect('/registration/form')->with('error',$e->getMessage());
            
        }
       
    }

    // create a function to load a login form
    public function loadLoginPage(){
        return view('login-page');
    }

    public function LoginUser(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6|max:8',
        ]);
        // now allow user to login if validation was successfully
        try {
            // login logic here
            $userCredentials = $request->only('email','password');

            if(Auth::attempt($userCredentials)){
                // redirect user to home page based on role
                if (auth()->user()->role == 2) {
                    return redirect('/admin/home');
                }elseif(auth()->user()->role == 0){
                    return redirect('/employee/home');
                }elseif(auth()->user()->role == 1){
                    return redirect('/manager/home');
                }else{
                    return redirect('/')->with('error','Error to find your role');
                }
                
            }else{
                return redirect('/login/form')->with('error','Wrong User Credentials');
            }
        } catch (\Exception $e) {
            return redirect('/login/form')->with('error',$e->getMessage());
        }
    }
    // create function to load home page
    public function loadHomePage(){
       $logged_user =  Auth::user();
        // for admin we will load the profile details from here..
       $user_details =  User::where([['id',$logged_user->id],['role',2]])->first(); //this will get only the first data with role id of 2 also add the user_id
    //    if you use first() function it comes as an object not array so access details directly
        return view('admin.home-page',compact('user_details','logged_user'));
    }

    // perform logout function here
    public function LogoutUser(Request $request){
        Session::flush();
        Auth::logout();
        return redirect('/login/form');
    }

    // create forgot password function here to load a page
    public function forgotPassword(){
        return view('forgot-password');
    }

    // perform email sending logic here
    public function forgot(Request $request){
        // validate here
        $request->validate([
            'email' => 'required'
        ]);
        // check if email exist
        $user = User::where('email',$request->email)->get();

        foreach ($user as $value) {
            # code...
        }

        if(count($user) > 0){
            $token = Str::random(40);
            $domain = URL::to('/');
            $url = $domain.'/reset/password?token='.$token;

            $data['url'] = $url;
            $data['email'] = $request->email;
            $data['title'] = 'Password Reset';
            $data['body'] = 'Please click the link below to reset your password';

            Mail::send('forgotPasswordMail',['data' => $data], function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });

            // $dataTime = Carbon::now()->format('Y-m-d H:i:s');

            $passwordReset = new PasswordReset;
            $passwordReset->email = $request->email;
            $passwordReset->token = $token;
            $passwordReset->user_id = $value->id;
            // $passwordReset->created_at = $dataTime;
            $passwordReset->save();

            return back()->with('success','please check your mail inbox to reset your password');
        }else{
            return redirect('/forgot/password')->with('error','email does not exist!');
        }
    
    }

    public function loadResetPassword(Request $request){
        $resetData = PasswordReset::where('token',$request->token)->get();
        if(isset($request->token) && count($resetData) > 0){
            $user = User::where('id',$resetData[0]['user_id'])->get();
            foreach ($user as $user_data) {
                # code...
            }
            return view('reset-password',compact('user_data'));
        }else{
            return view('404');
        }
    }

    // perform password reset logic here

    public function ResetPassword(Request $request){
        $request->validate([
            'password' => 'required|min:6|max:8|confirmed'
        ]);
        try {
            $user = User::find($request->user_id);
            $user->password = Hash::make($request->password);
            $user->save();

            // delete reset token
            PasswordReset::where('email',$request->user_email)->delete();

            return redirect('/login/form')->with('success','Password Changed Successfully');
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }
}
