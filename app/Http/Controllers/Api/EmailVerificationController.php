<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserVerify;

class EmailVerificationController extends Controller
{
    public function AccountVerification($token) {
        $verifyUser = UserVerify::where('token', $token)->first();

        if(!is_null($verifyUser)) {
            $user = $verifyUser->user;

            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                return response([
                    'message' => 'Your e-mail is verified. You can login now!',
                ]);
            }
            else 
            {
                return response([
                    'message' => 'Your e-mail is already verified. You can now login.'
                ]);
            }
        }

        return response([
            'message' => 'Sorry your e-mail cannot be identified',
        ]);
    }
}
