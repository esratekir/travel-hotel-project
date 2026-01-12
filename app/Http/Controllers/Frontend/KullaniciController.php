<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Image;
use App\Models\Settings;
use App\Models\Destination;
use App\Models\City;

use App\Mail\EmailVerification;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;

class KullaniciController extends Controller
{
    public function register_action(Request $request)
    {   
        $request->validate([
        'name' => 'required',
        'email' => 'required|unique:tb_user',
        'username' => 'required',
        'password' => 'required|min:6',
        ]);
    
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'is_approved' => 1,
        ]);
  
        $user->save();
        $user->syncRoles("user");
        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $user->user_id, 
              'token' => $token
            ]);
  
        Mail::send('frontend.auth.verify-email', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });

        $notification = array(
            'message' => 'You registered successfully!You need to confirm your account. We have sent you an activation code, please check your email',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
              
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
  
        return redirect()->route('home')->with('message', $message);
    }

    public function login_user(Request $request){

        $login = $request->input('email');
        $user = User::where('email', $login)->orWhere('username', $login)->first();

        if (!$user) {
            $notification = array(
                'message' => 'Email/Username or Pasword is incorrect!',
                'alert-type' => 'info',
            );
            return redirect()->back()->with($notification);
        }
        $request->validate([
            
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if (auth()->attempt(['email' => $user->email, 'password' => $request->password, 'is_email_verified' => 1, 'is_approved' => 1]) || 
            auth()->attempt(['username' => $user->username, 'password' => $request->password, 'is_email_verified' => 1, 'is_approved' => 1])) {
            $request->session('user_id');
            $notification = array(
                'message' => 'You logged in successfully!', 
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        else
        {
            $notification = array(
                'message' => 'Email or Password is Incorrect. Or your account didnt approved. Or You need to confirm your account. We have sent you an activation code, please check your email',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    

    public function destroy(Request $request): RedirectResponse{    
        Auth::logout();
        $notification = array(
          'message' => 'You Logout Successfully',
          'alert-type' => 'success'
        );

        return redirect()->route('home')->with($notification);
    } //end method

    public function UserProfile() {  //burada idsini veritabanından aldığımız kullanıcının profil sayfasına gitmesi için bi fonksiyon atadık
        $id = Auth::user()->user_id;    //hangi id girdiyse admin panele onun idsini bulur
        $userData = User::find($id); //bulduğunu adminData ya atar
        $countries = Destination::orderBy('country', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();
        return view('frontend.user.user_profile', compact('userData', 'countries', 'cities')); //oluşturduğumuz admin_profile_viewi compact ile karşılaştırıp ile adminin profilini gösterir
    }//end method

    public function UpdateUser(Request $request) {
        $id = Auth::user()->user_id;  //burada database deki name username email i $data değişkenine attık kullanıcı edit profile sayfasında adını mailini kullancı adını yazdıığında güncelleyecek
        $data = User::find($id);

        if($request->file('image')) {

            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->description = $request->description;
            $data->country = $request->country;
            $data->city = $request->city;

            $image = $request->file('image');
            $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Logo dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/user_images/'.$name_gen);
            $save_url = 'upload/user_images/'.$name_gen;
            $data->image = $save_url;
            $data->save();

            $notification = array(
                'message' => 'Your Profile Updated Successfully',
                'alert-type' => 'success'
            );


            return redirect()->route('user.profile')->with($notification);
        }
        else {
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->description = $request->description;
            $data->country = $request->country;
            $data->city = $request->city;
            $data->save();
            $notification = array(
                'message' => 'Your Profile Updated Successfully',
                'alert-type' => 'success'
            );


            return redirect()->route('user.profile')->with($notification);
        }
        

    }


    public function LocalUserDetails($username) {
        $users = User::with('comments')->where('username', $username)->first();
        $settings= Settings::find(1);
        return view('frontend.user.user_details', compact('users', 'settings'));
    }

}
