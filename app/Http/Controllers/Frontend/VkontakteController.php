<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VkontakteController extends Controller
{
    public function VkontakteAuth() {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function VkontakteCallback() {
        try {
            
            $user = Socialite::driver('vkontakte')->stateless()->user();
            $findUser = User::where('vkontakte_id', '=', $user->id)->first();


            if($findUser) {
                Auth::login($findUser);
                return redirect()->intended('/');
            }
            else {

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->nickname,
                    'vkontakte_id' => $user->id,
                    'password' => Hash::make('fiber155.'),
                    'image' => $user->avatar,
                    'is_approved' => 1,
                    'is_email_verified' => 1,
                ]);
                $newUser->syncRoles("user");
    
                Auth::login($newUser);
                return redirect()->intended('/user/profile');
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
