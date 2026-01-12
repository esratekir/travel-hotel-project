<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Destination;
use Image;
use App\Models\Activity;
use App\Models\Languages;
use App\Models\City;
use App\Models\GuideLanguage;
use App\Models\GuideActivity;
use App\Models\UserImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;

class GuideController extends Controller
{   
    public function GuideRegister(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:tb_user',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|not_regex:/[a-z]/|min:9|max:15',
        ]);
        $request->session()->forget('guide_reg');
        $guide_reg = new User();
        $guide_reg->fill($validatedData);
        $request->session()->put('guide_reg', $guide_reg);
        
        return redirect()->route('guide.register.step1');
        
    }

    public function GuideStep1(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        return view('frontend.guide_register.register1', compact('guide_reg'));
    }


    public function UpdateGuideStep1(Request $request){
        $guide_reg = $request->session()->get('guide_reg');
        $validatedData = $request->validate([
            'username' => 'required|unique:tb_user',
            'gender' => 'required',
            'description' => 'required|min:6',
            'motto' => 'required',
            'password'=> 'required|min:6',
            'confirm_password'=> 'required|same:password',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',        
        ]);
                
        $guide_reg->password = Hash::make($request->password);
        $guide_reg->confirm_password = Hash::make($request->password);
        $guide_reg->username = $request->username;
        $guide_reg->motto = $request->motto;
        $guide_reg->description = $request->description;
        $guide_reg->gender = $request->gender;
       
        $image = $request->file('image');
        
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->save('upload/user_gallery/'.$name_gen);
        $save_url = 'upload/user_gallery/'.$name_gen;
        $guide_reg = $request->session()->get('guide_reg');
        $guide_reg->image= $save_url;
    
        $request->session()->put('guide_reg', $guide_reg);
                
        return redirect()->route('guide.register.step2');
    }

    public function GuideStep2(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        $countries = Destination::orderBy('country', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();

        return view('frontend.guide_register.register2', compact('guide_reg', 'countries', 'cities'));
    }

    public function getCitiesByCountry($countryId)
    {   $cities = City::where('country_id', $countryId)->get();
        return response()->json($cities);
    }
    
    public function UpdateGuideStep2(Request $request){
        
        $validatedData = $request->validate([
            'country' => 'required',
            'city' => 'required',
        ]);
        $guide_reg = $request->session()->get('guide_reg');
        $guide_reg->country_select = $request->country;
        $guide_reg->city_select = $request->city;
        $request->session()->put('guide_reg', $guide_reg);
        
        return redirect()->route('guide.register.step3');
    }

    public function GuideStep3(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        $language = Languages::orderBy('language', 'ASC')->get();

        return view('frontend.guide_register.register3', compact('guide_reg', 'language'));
    }

    public function UpdateGuideStep3(Request $request) {
        $request->validate([
            'language' => 'required',
        ]);        
        $languages = $request->language;
        $lang_array = []; 
        foreach ($languages as $key => $value) {
            $lang_array[] = $value;    
        }

        $guide_reg = $request->session()->get('guide_reg');
        $guide_reg->language_select = $lang_array;
        $request->session()->put('guide_reg', $guide_reg);
            
        return redirect()->route('guide.register.step4');      
    }

    public function GuideStep4(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        $activities = Activity::orderBy('activity_name', 'ASC')->get();
        return view('frontend.guide_register.register4', compact('guide_reg', 'activities'));
    }

    public function UpdateGuideStep4(Request $request) {
        $request->validate([
            'activity' => 'required',
        ]);
        $activitis = $request->activity;
        $act_array= [];
        foreach ($activitis as $key => $value) {
            $act_array[] = $value; 
        }
        $guide_reg = $request->session()->get('guide_reg');
        $guide_reg->activity_select = $act_array;
        $request->session()->put('guide_reg', $guide_reg);
        return redirect()->route('guide.register.step5');
    }

    public function GuideStep5(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        
        return view('frontend.guide_register.register5',compact('guide_reg'));
    }

    public function UpdateGuideStep5(Request $request){
       
        $request->validate([
            'fullday_tour' => 'required',
            'morning_city_tour' => 'required',
            'city_tour' => 'required',
            'night_tour' => 'required',
            'price' => 'required',
            'airport_transfer_price' => 'required',
        ]);

        $guide_reg = $request->session()->get('guide_reg');
        $guide_reg->fullday_tour = $request->fullday_tour;
        $guide_reg->morning_city_tour = $request->morning_city_tour;
        $guide_reg->city_tour = $request->city_tour;
        $guide_reg->night_tour = $request->night_tour;
        $guide_reg->price = $request->price;
        $guide_reg->airport_transfer_price= $request->airport_transfer_price;
        $request->session()->put('guide_reg', $guide_reg);
            
        return redirect()->route('guide.register.step6');
    }

    public function GuideStep6(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        $all_image = session('all_image');

        return view('frontend.guide_register.register6', compact('guide_reg', 'all_image'));
    }
    
    public function UpdateGuideStep6(Request $request){
        $guide_reg = $request->session()->get('guide_reg');
        if(isset($guide_reg->uploaded_images)){
        $img_array = $guide_reg->uploaded_images;
        }
        else{
            $img_array = [];
        }
        
        if($request->file('file') !== null){
            $image = $request->file('file');
        
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/user_gallery/'.$name_gen);
            $save_url = 'upload/user_gallery/'.$name_gen;
            $guide_reg = $request->session()->get('guide_reg');

            $img_array[] = $save_url;
            $guide_reg->uploaded_images = $img_array;
            $request->session()->put('guide_reg', $guide_reg);
            
            return redirect()->route('guide.register.step6');
        }
  
    }

    public function GuideRegisterComplete(Request $request){
        $guide_reg = $request->session()->get('guide_reg');
        $user = new User();
        $user->name = $guide_reg['name'];
        $user->email = $guide_reg['email'];
        $user->phone = $guide_reg['phone'];
        $user->username = $guide_reg['username'];
        $user->gender = $guide_reg['gender'];
        $user->password = $guide_reg['password'];
        // $user->confirm_password = $guide_reg['confirm_password'];
        $user->motto = $guide_reg['motto'];
        $user->description = $guide_reg['description'];
        $user->country = $guide_reg['country_select'];
        $user->city = $guide_reg['city_select'];
        $user->fullday_tour = $guide_reg['fullday_tour'];
        $user->morning_city_tour = $guide_reg['morning_city_tour'];
        $user->city_tour= $guide_reg['city_tour'];
        $user->night_tour = $guide_reg['night_tour'];
        $user->price = $guide_reg['price'];
        $user->airport_transfer_price = $guide_reg['airport_transfer_price'];
        $user->image = $guide_reg['image'];
        $user->is_approved = 0;
        $user->save();
        $user->syncRoles('guide');

        

        foreach ($guide_reg->uploaded_images as $image) {
            $userImage = new UserImage(['image' => $image, 'userid' => $user->user_id]);
            $userImage->save();
        }

        foreach ($guide_reg->language_select as $language) {
            $guideLanguage = new GuideLanguage(['language_id' => $language, 'guide_id' => $user->user_id]);
            $guideLanguage->save();
        }

        foreach ($guide_reg->activity_select as $activity) {
            $guideActivity = new GuideActivity(['activity_id' => $activity, 'guide_id' => $user->user_id]);
            $guideActivity->save();
        }

        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $user->user_id, 
              'token' => $token
            ]);
        
        Mail::send('frontend.auth.verify-email', ['token' => $token], function($message) use($user){
            $message->to($user->email);
            $message->subject('Email Verification Mail');
            
            
        });

        

        $notification = array(
            'message' => 'Registration is successfully.You need to confirm your account. We have sent you an activation code, please check your email.And you can expect us to approve you as a guide!',
            'alert-type' => 'success',
        );
        
        return redirect()->route('home')->with($notification);
       
    }

    public function DeleteGuideImage2(Request $request) {
        $guide_reg = $request->session()->get('guide_reg');
        $img_array = $guide_reg->uploaded_images;
        $deleteFileName = $request->input('id');
       
        if (($key = array_search($deleteFileName, $img_array)) !== false) {
            unset($img_array[$key]);
        }

        $guide_reg->uploaded_images = $img_array;
        return $img_array;
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


    public function GuideProfile(){
        //burada idsini veritabanından aldığımız adminin profil sayfasına gitmesi için bi fonksiyon atadık
        $id = Auth::user()->user_id;    //hangi id girdiyse admin panele onun idsini bulur
        $userData = User::find($id); //bulduğunu adminData ya atar
        return view('frontend.guide.guide_profile', compact('userData')); //oluşturduğumuz admin_profile_viewi compact ile karşılaştırıp ile adminin profilini gösterir
    }

    public function GuideUpdateProfile1(Request $request) {
        
        $id = Auth::user()->user_id;  //burada database deki name username email i $data değişkenine attık kullanıcı edit profile sayfasında adını mailini kullancı adını yazdıığında güncelleyecek
        $data = User::find($id);

        if($request->file('image')){
            $image = $request->file('image');
            $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Image file extension should only be jpg, png, jpeg!',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/guide_profile_photo/'.$name_gen);
            $save_url = 'upload/guide_profile_photo/'.$name_gen;
            
            User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'description' => $request->description,
            'motto' => $request->motto,
            'password' => Hash::make($request->password),
            'image' => $save_url,
            ]);
            
            $notification = array(
                'message' => 'Your profile information has been successfully updated.',
                'alert-type' => 'success',
            );
            return redirect()->back()->with($notification);
        }
        else {
            User::findOrFail($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'description' => $request->description,
                'motto' => $request->motto,
                'password' => Hash::make($request->password),
            ]);
            $notification = array(
                'message' => 'Your profile information has been successfully updated.',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function GuideProfile2() {
        $id = Auth::user()->user_id;  
        $data = User::find($id);
        $countries = Destination::orderBy('country', 'asc')->get();
        $cities = City::orderBy('name', 'asc')->get();
        return view('frontend.guide.guide_profile2',compact('data','countries', 'cities'));
    }

    public function GuideUpdateProfile2(Request $request){
        $data = User::findOrFail($request->user_id);
        $data->country = $request->country;
        $data->city = $request->city;
        $data->save();
        return redirect()->back();
    }

    public function GuideProfile3(){
        $id = Auth::user()->user_id;  
        $data = User::find($id);
        $language = Languages::orderBy('language', 'ASC')->get()->all();
        $guide_lang = GuideLanguage::where('guide_id','=' ,$id)->get()->pluck('language_id')->toArray();
    
        return view('frontend.guide.guide_profile3',compact('data', 'language', 'guide_lang'));
    }

    public function GuideUpdateProfile3(Request $request){
        $language = GuideLanguage::where('guide_id',"=", $request->user_id)->get();
        foreach ($language as $key => $value) {
            GuideLanguage::findOrFail($value["id"])->delete();
        }
            
        $languages = $request->language;
        foreach ($languages as $key => $value) {
            GuideLanguage::where('guide_id',"=", $request->user_id)->insert([
                'guide_id' => $request->user_id,
                'language_id' => $value,
            ]);
        }   
        return redirect()->back();
    }

    public function GuideProfile4(){
        $id = Auth::user()->user_id;  
        $data = User::find($id);
        $activities = Activity::orderBy('activity_name', 'ASC')->get();
        $guide_act = GuideActivity::where('guide_id','=' ,$id)->get()->pluck('activity_id')->toArray();
        return view('frontend.guide.guide_profile4',compact('data', 'activities','guide_act'));
    }

    public function GuideUpdateProfile4(Request $request){
        $activity = GuideActivity::where('guide_id',"=", $request->user_id)->get();
        foreach ($activity as $key => $value) {
            GuideActivity::findOrFail($value["id"])->delete();
        }
        
        $activitis = $request->activity;
        foreach ($activitis as $key => $value) {
            GuideActivity::where('guide_id',"=", $request->user_id)->insert([
                'guide_id' => $request->user_id,
                'activity_id' => $value,
            ]);
        }
        return redirect()->back();
    }

    public function GuideProfile5(){
        $id = Auth::user()->user_id;  
        $data = User::find($id);
        return view('frontend.guide.guide_profile5',compact('data'));
    }

    public function GuideUpdateProfile5(Request $request){
        $request->validate([
            'fullday_tour' => 'required',
            'morning_city_tour' => 'required',
            'city_tour' => 'required',
            'night_tour' => 'required',
            'price' => 'required',
            'airport_transfer_price' => 'required',
        ]);
        $data = User::findOrFail($request->user_id);
        $data->fullday_tour = $request->fullday_tour;
        $data->morning_city_tour = $request->morning_city_tour;
        $data->city_tour = $request->city_tour;
        $data->night_tour = $request->night_tour;
        $data->price = $request->price;
        $data->airport_transfer_price = $request->airport_transfer_price;
        $data->save();
        return redirect()->back();
    }

    public function GuideProfile6(){
        $id = Auth::user()->user_id;  
        $data = User::find($id);
        $all_image = UserImage::where('userid' , '=', $id)->orderBy('id', 'ASC')->get();
        return view('frontend.guide.guide_profile6',compact('data', 'all_image'));
    }

    public function GuideUpdateProfile6(Request $request){
        $data = User::findOrFail($request->user_id);
        
        if($request->file('file') !== null){
            $image = $request->file('file');
           
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->save('upload/user_gallery/'.$name_gen);
            $save_url = 'upload/user_gallery/'.$name_gen;

            $imageUpload = new UserImage();
            $imageUpload->image = $save_url;
            $imageUpload->userid = $request->user_id;
            $imageUpload->save(); 
             
        }
        return redirect()->back();
    }

    public function GuideProfile7(){
        $id = Auth::user()->user_id;  
        $data = User::find($id);
        return view('frontend.guide.guide_profile7',compact('data'));
    }

    public function GuideUpdateProfile7(Request $request){
        $data = User::findOrFail($request->user_id);
        
        $validateData = $request->validate([
            'password'=> 'required|min:6',
            'confirm_password'=> 'required|same:password',
        ]);
        $data->password = Hash::make($request->password);
        $data->save();
       
            
        $notification = array(
            'message' => 'Your password has been successfully updated.',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteUserImage($id) {
        $multi_id = UserImage::findOrFail($id);
        $img = $multi_id->image;
        unlink($img);

        $sil = UserImage::where('id', '=', $id)->delete();

        echo $sil;
    }
    
}
