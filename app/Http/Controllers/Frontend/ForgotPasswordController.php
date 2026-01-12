<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

    public function SubmitForgotPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:tb_user',
        ]);

        $token = Str::random(64);

        PasswordReset::insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('frontend.auth.email_ForgotPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->back()->with('message', 'We have e-mailed your password reset link!');

    }


    public function ShowResetPassword($token) {
        return view('frontend.auth.resetpassword_link', ['token' => $token]);
    }

    public function SubmitResetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:tb_user',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();

        if(!$updatePassword) {
            return redirect()->back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('home')->with('message', 'Your password has been changed!');

    }
}
