<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserVerify;
use Hash;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\GuideLanguage;
use App\Models\GuideActivity;
use App\Models\UserImage;
use Image;
use App\Models\City;
use App\Models\Languages;

class GuideController extends Controller
{
    public function register(Request $request) {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:tb_user',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|not_regex:/[a-z]/|min:9|max:15',
            'username' => 'required|unique:tb_user',
            'gender' => 'required',
            'description' => 'required|min:6',
            'motto' => 'required',
            'password'=> 'required|min:6',
            'confirm_password'=> 'required|same:password',
            'country' => 'required',
            'city' => 'required',
            'language' => 'required',
            'activities' => 'required',
            'fullday_tour' => 'required',
            'morning_city_tour' => 'required',
            'city_tour' => 'required',
           'night_tour' => 'required',
            'price' => 'required',
            'airport_transfer_price' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }
    
        $token = bin2hex(random_bytes(20));
		$rtoken = bin2hex(random_bytes(20));

        $user = new User([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'gender' => $request->gender,
            'country' => $request->country,
            'city' => $request->city,
            'fullday_tour' => $request->fullday_tour,
            'morning_city_tour' => $request->morning_city_tour,
            'city_tour' => $request->city_tour,
            'night_tour' => $request->night_tour,
            'airport_transfer_price' => $request->airport_transfer_price,
            'price' => $request->price,
            'motto' => $request->motto,
            'token' => $token,
            'rtoken' => $rtoken,
            'token_created_at' => Carbon::parse(Carbon::now()),
            'token_expired_at' => Carbon::parse(Carbon::now()->addDay(1))->toDateTimeString(),
            'rtoken_created_at' => Carbon::parse(Carbon::now()),
            'rtoken_expired_at' => Carbon::parse(Carbon::now()->addMinutes(1500))->toDateTimeString(),
            'is_approved' => 0,

        ]);
        $user->save();
        $user->syncRoles("guide");
        // $token = $user->createToken('auth_token')->accessToken; 
        $code = Str::random(64);
      
        UserVerify::create([
            'user_id' => $user->user_id, 
            'token' => $code
        ]);
        Mail::send('frontend.auth.verify-email', ['token' => $code], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
        });

        $languages = $request->language;
        foreach ($languages as $key => $value) {
            GuideLanguage::insert([
                'guide_id' => $user["user_id"],
               'language_id' => $value,
            ]);
        }

        $language = GuideLanguage::where('guide_id', $user->user_id)->with('language')->get();

        $activity = $request->activities;
        foreach ($activity as $key => $value) {
            GuideActivity::insert([
                'guide_id' => $user["user_id"],
               'activity_id' => $value,
            ]);
        }
        $activitys = GuideActivity::where('guide_id',$user->user_id)->with('activiti')->get();

        $user = User::where('user_id', $user->user_id)->with('Country', 'Citi','Language','Activit')->first();
        $user_role = User::where('user_id', $user->user_id)->with('roles')->first();
        $userRole = $user_role->roles->first();

        $user->makeHidden(['rtoken','rtoken_created_at', 'rtoken_expired_at','password','confirm_password','phone','last_seen','created_at','updated_at','is_approved','email_verified_at','is_email_verified','google_id','facebook_id','vkontakte_id']);
        return response([
            'user' => $user,
            'roles' => $userRole,
        ]);
        // return response([
        //     $user,
        //     'languages' => $language,
        //     'activities' => $activitys,
        //     'email_verification_code' => $code,
        // ]);
    }

    public function store(Request $request, $token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }
        
        $image = $request->file('image');
        if($image) {
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('upload/guides/' . $name_gen);
            $save_url = 'upload/guides/' . $name_gen;

            $user->image = $save_url;
            $user->save();
            return response([
                'image_way' => $user->image,
                'message' => 'Image uploaded succesfully'
            ]);
        }
        else
        {
            return response([
                'error_status' => '1',
                'message' => 'Image didnt upload'
            ]);
        }
    }

    public function GuideImageUpload(Request $request, $token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }
        
        $rules = [
            'image' => 'required',
            'image.*' => 'mimes:jpeg,png,jpg,svg|max:2048',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }

        $image = $request->file('image');
        $image_array = [];
        if($image) {
            foreach ($image as $user_image) {
                $name_gen = hexdec(uniqid()).'.'.$user_image->getClientOriginalExtension();
        
                Image::make($user_image)->save('upload/user_gallery/'.$name_gen);
                $save_url = 'upload/user_gallery/'.$name_gen;
        
                $userimage = UserImage::create([
                    'userid' => $user->user_id,
                    'image' => $save_url,
                    'created_at' => Carbon::now()
                ]);
                $image_array[] = $userimage;
            } //end of the foreach
            return response([
                'message' => 'image uploaded successfullly',
                'images' => $image_array
            ]);

        }
    }

    public function AllGuides(Request $request) {
        $query = User::query();

        if ($request->filled('city')) {
            $cityName = $request->city;
            $city = City::where('name', 'like', '%' . $cityName . '%')->first();
    
            if ($city) {
                $cityId = $city->id;
                $query->whereHas('Citi', function($q) use ($cityId) {
                    $q->where('city', $cityId);
                });
            }
        }
        
        if ($request->filled('price')) {
            // Fiyat aralığına göre filtreleme
            $query->where('price', '<=' , $request->price);
        }
       
        if ($request->has('online_only')) {
            // Çevrimiçi olan rehberleri getir
            $query->where('last_seen', '>', now()->subMinutes(5)); // Burada online_status sütununun adını ve doğru değerini kullanmalısınız
        }
        
        if(isset($request->language) && ($request->language != null)){
            $guide_lang_query = GuideLanguage::where('language_id', '=', $request->language)->get();
                
            $user_id_lang = [];
            foreach($guide_lang_query as $guide_lang) {
                $user_id_lang[]  .= $guide_lang->guide_id;
            }
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if(isset($request->language) && ($request->language != null)){
            $guides = $query->whereHas("roles", function($q){ $q->where("name", "guide"); })->whereIn('user_id',  $user_id_lang)->withCount('comments')->where('is_approved', '=', 1)->orderBy('comments_count', 'desc')->with( 'Language', 'Activit', 'Country', 'UserImage','Citi')->get();
        }
        else {
            $guides = $query->whereHas("roles", function($q){ $q->where("name", "guide"); })->withCount('comments')->where('is_approved', '=', 1)->orderBy('comments_count', 'desc')->with('Language', 'Activit', 'Country', 'UserImage','Citi')->get();
        }

        $guides->makeHidden(['token','token_created_at', 'token_expired_at', 'rtoken','rtoken_created_at', 'rtoken_expired_at','username','password','confirm_password','email', 'phone','last_seen','created_at','updated_at','is_approved','email_verified_at','is_email_verified','google_id','facebook_id','vkontakte_id']);
        
        return response(['guides' => $guides]);
    }

    public function showDetails($token, $id) {
        $guide_token = User::where('token', $token)->first();
        $user_id = User::where('user_id', $id)->first();
        if(!$guide_token) {
            return response([
                'error_status' => '1',
                'message' => 'token is invalid.'
            ]);
        }

        $requested_guide = User::find($id);
        if(!$requested_guide) {
            return response([
                'error_status' => '1',
                'message' => 'This guide is undifinded.'
            ]);
        }

        if($guide_token->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }
        $activities = User::where('user_id', '=', $user_id)->get();
        $guide_images = UserImage::where('userid', '=', $user_id)->pluck('image');

        $guides = User::with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi', 'roles')->where('user_id', $id)->first();

        // İstenmeyen alanları kaldırın
        $unwantedFields = ['token', 'rtoken', 'token_created_at', 'token_expired_at', 'rtoken_created_at', 'rtoken_expired_at','password','confirm_password'];

        $filteredGuides = $guides->toArray();
        foreach ($unwantedFields as $field) {
            unset($filteredGuides[$field]);
        }

        // Sonucu döndürün
        return response([
            $filteredGuides,
        ]);
    }

    public function DeleteGuideImage($token, $id) {
        $guide_token = User::where('token', $token)->first();
        $user_id = User::where('user_id', $id)->first();
        if(!$guide_token) {
            return response([
                'error_status' => '1',
                'message' => 'token is invalid.'
            ]);
        }

        $requested_guide = UserImage::findOrFail($id)->first();
        if(!$requested_guide) {
            return response([
                'error_status' => '1',
                'message' => 'This image is undefinded.'
            ]);
        }

        if($guide_token->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        // $img = $guide_token->image;
        // unlink($img);

        $sil = UserImage::where('id', '=', $id)->delete();

        return response([
            'message' => 'Image deleted successfully',
        ]);
    }

    public function GetGuideProfile($token) {
        $guide_token = User::where('token', $token)->first();

        if(!$guide_token) {
            return response([
                'error_status' => '1',
                'message' => 'token is invalid.'
            ]);
        }

        if($guide_token->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $userId = User::where('token', $token)->pluck('user_id');
        $userData = User::where('token', $token)->with('Language','UserImage', 'Activit', 'Country', 'Citi', 'roles')->first();

        $unwantedFields = ['token', 'rtoken', 'token_created_at', 'token_expired_at', 'rtoken_created_at', 'rtoken_expired_at', 'password', 'confirm_password'];

        $filteredGuides = $userData->toArray();
        foreach ($unwantedFields as $field) {
            unset($filteredGuides[$field]);
        }
        return response([
            'guide' => $filteredGuides,
        ]);
    }

    public function GuideProfileUpdate(Request $request, $token) {
        
        $guide_token = User::where('token', $token)->with('Country', 'Citi')->first();

        // $rules = [
        //     'email' => 'email|exists:tb_user',
        //     'username' => 'exists:tb_user',
        //     'phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|not_regex:/[a-z]/|min:9|max:15',
        //     'description' => 'min:6',
        // ];
    
        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails()) {
        //     return response()->json(['message' => $validator->errors(), 'hatadurumu' => 1]);
        // }
    
        if (!$guide_token) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }
    
        if ($guide_token->token_expired_at <= now()) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }
    
        $guide_id = User::where('token', $token)->pluck('user_id');
        $userToUpdate = User::findOrFail($guide_id)->first();
    
        /// Güncellenecek alanları seç
        $updateFields = $request->only(['name', 'username', 'email', 'phone', 'description', 'gender', 'country', 'city', 'fullday_tour', 'morning_city_tour', 'city_tour', 'night_tour', 'airport_transfer_price', 'price', 'motto']);

        // Alanlar boşsa null dönmeyi önle
        $updateFields = array_filter($updateFields, 'filled');

        // Güncelleme işlemi
        $userToUpdate->update($updateFields);

        
    
        // Dil ve aktivite güncellemeleri...

        $languageRecords = GuideLanguage::where('guide_id', $guide_id)->get();
        if ($languageRecords->isNotEmpty()) {
            foreach ($languageRecords as $record) {
                $record->delete();
            }
        }

        $languages = $request->language;
        if (!empty($languages)) {
            foreach ($languages as $value) {
                GuideLanguage::create([
                    'guide_id' => $guide_token["user_id"],
                    'language_id' => $value,
                ]);
            }
        }

        $activityRecords = GuideActivity::where('guide_id', $guide_id)->get();
        if ($activityRecords->isNotEmpty()) {
            foreach ($activityRecords as $record) {
                $record->delete();
            }
        }

        $activities = $request->activities;
        if (!empty($activities)) {
            foreach ($activities as $value) {
                GuideActivity::create([
                    'guide_id' => $guide_token["user_id"],
                    'activity_id' => $value,
                ]);
            }
        }

        $userToUpdate = User::where('token', $token)->with('Language', 'Activit','Country', 'Citi')->first();
        $unwantedFields = ['token', 'rtoken', 'token_created_at', 'token_expired_at', 'rtoken_created_at', 'rtoken_expired_at', 'password', 'confirm_password','email_verified_at','is_email_verified','google_id','facebook_id','vkontakte_id','is_approved'];

        $filteredGuides = $userToUpdate->toArray();
        foreach ($unwantedFields as $field) {
            unset($filteredGuides[$field]);
        }
       
        return response([
            'message' => 'Your profile updated successfully.',
            'user' => $filteredGuides,
        ]);


    }
}
