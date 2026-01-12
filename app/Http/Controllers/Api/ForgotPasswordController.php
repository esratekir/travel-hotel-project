<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use App\Models\PasswordReset;
use App\Models\User;
use Hash;

class ForgotPasswordController extends Controller
{
    public function SubmitForgotPassword(Request $request) {
        $rules = [
            'email' => 'required|email|exists:tb_user',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }

        PasswordReset::where('email', $request->email)->delete();

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

        return response([
            'message' => 'We have e-mailed your password reset link!',
            'code' => $token,
        ]);
    }

    // public function ShowResetPassword($token) {
    //     return view('frontend.auth.resetpassword_link', ['token' => $token]);
    // }

    public function SubmitResetPassword(Request $request, $token) {
        $rules = [
            'email' => 'required|email|exists:tb_user',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ];

        $validator = Validator::make($request->all(), $rules);
         if($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }


        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $token,
        ])->first();
        
        if(!$updatePassword) {
            return response([
                'error_status' => 1,
                'message' => 'Invalid token'
            ]);
        }

        if($updatePassword->created_at > now()->addHour()) {
            $updatePassword->delete();
            return response([
                'error_status' => 1,
                'message' => 'Token is expired.',
            ]);
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        PasswordReset::where('email', $request->email)->delete();

        return response([
            'message' => 'Your password has been changed!'
        ]);
    }
}
