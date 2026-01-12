<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleAuthController extends Controller
{
    public function GoogleAuth() {
        return Socialite::driver('google')->redirect();
    }

    public function GoogleCallback() {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('google_id', '=', $user->id)->first();

            if($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/');
            }
            else {
            $email = User::where('email', $user->getEmail())->first();

                if(!$email) {
                    $newUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        'password' => Hash::make('fiber155.'),
                        'image' => $user->image,
                        'is_approved' => 1,
                        'is_email_verified' => 1,
                    ]);
                    $newUser->syncRoles("user");
    
                    Auth::login($newUser);
                    return redirect()->intended('/user/profile');
                }
                else {
                    $notification = array(
                        'message' => 'Sorry ! This email Already Exists',
                        'alert-type' => 'warning',
                    );

                    return redirect()->back()->with($notification);
                }
                
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
