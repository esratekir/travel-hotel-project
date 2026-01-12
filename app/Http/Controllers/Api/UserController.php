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
use Image;

class UserController extends Controller
{
    public function generateToken($user)
    {
        $token = bin2hex(random_bytes(20));
        $rtoken = bin2hex(random_bytes(20));
        $user->update([
            'token' => hash('sha256', $token),
            'rtoken' => $rtoken,
            'token_created_at' => Carbon::parse(Carbon::now()),
            'token_expired_at' => Carbon::parse(Carbon::now()->addDay(1))->toDateTimeString(),
            'rtoken_created_at' => Carbon::parse(Carbon::now()),
            'rtoken_expired_at' => Carbon::parse(Carbon::now()->addMinutes(1500))->toDateTimeString(),
        ]);
        return $token;
    }
    
    public function register(Request $request) {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|unique:tb_user',
                'username' => 'required',
                'password' => 'required|min:6',  
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
            }
    
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'is_approved' => 1,    
            ]);
    
            $user->save(); 
    
            $user->syncRoles("user");
            $token = $this->generateToken($user);
            
            $code = Str::random(64);
          
            UserVerify::create([
                'user_id' => $user->user_id, 
                'token' => $code
            ]);
            Mail::send('frontend.auth.verify-email', ['token' => $code], function($message) use($request){
                $message->to($request->email);
                $message->subject('Email Verification Mail');
            });
    
            return response([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            \Log::error('Veritabanı Hatası: ' . $e->getMessage());
            
            return response()->json(['message' => 'Veritabanı hatası oluştu.', 'error_status' => 1]);
        }
    }

    public function login(Request $request) {
        $login = $request->input('email');
        $user = User::where('email', $login)->orWhere('username', $login)->first();

        if (!$user) {
            return response([
                'hatadurumu' => '1',
                'message' => 'Email/Username or Pasword is incorrect!'
             ],401);
        }

        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }
        
        if (auth()->attempt(['email' => $user->email, 'password' => $request->password, 'is_email_verified' => 1, 'is_approved' => 1]) || 
            auth()->attempt(['username' => $user->username, 'password' => $request->password, 'is_email_verified' => 1, 'is_approved' => 1])) {
            //$token = $user->createToken('auth_token')->accessToken;

            //giriş yapmak isteyen kullanıcının tokenı boşsa yeni token ve refresh-token oluşturup veritabanında token,rtoken ve oluşturma sürelerini güncelliyoruz
            if(empty($user->token)) {
                $token = bin2hex(random_bytes(20));
			    $rtoken = bin2hex(random_bytes(20));

                User::findOrFail($user->user_id)->update([
                    'token' => $token,
                    'rtoken' => $rtoken,
                    'token_created_at' => Carbon::parse(Carbon::now()),
                    'token_expired_at' => Carbon::parse(Carbon::now()->addDay(1))->toDateTimeString(),
                    'rtoken_created_at' => Carbon::parse(Carbon::now()),
                    'rtoken_expired_at' => Carbon::parse(Carbon::now()->addMinutes(1500))->toDateTimeString(),
                ]);

                $user = User::where('user_id', $user->user_id)->with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi')->first();
                    $user_role = User::where('user_id', $user->user_id)->with('roles')->first();
                    $userRole = $user_role->roles->first();

                    return response([
                        'user' => $user,
                        'roles' => $userRole,
                    ]);
            }
            //eğer kullanıcının tokenı varsa bu sefer tokenın bitiş süresi şuanki tarihten küçükse yani tokenın süresi bitmişse yeniden token oluşturup veritabanında token rtoken ve sürelerini güncelleniyor
            else {
                
                if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
                    $token = bin2hex(random_bytes(20));
                    $rtoken = bin2hex(random_bytes(20));

                    User::findOrFail($user->user_id)->update([
                        'token' => $token,
                        'rtoken' => $rtoken,
                        'token_created_at' => Carbon::parse(Carbon::now()),
                        'token_expired_at' => Carbon::parse(Carbon::now()->addDay(1))->toDateTimeString(),
                        'rtoken_created_at' => Carbon::parse(Carbon::now()),
                        'rtoken_expired_at' => Carbon::parse(Carbon::now()->addMinutes(1500))->toDateTimeString(),
                    ]);
                    $user = User::where('user_id', $user->user_id)->with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi')->first();
                    $user_role = User::where('user_id', $user->user_id)->with('roles')->first();
                    $userRole = $user_role->roles->first();

                    return response([
                        'user' => $user,
                        'roles' => $userRole,
                    ]);
                }
                else
                {
                    $user = User::where('user_id', $user->user_id)->with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi')->first();
                    $user_role = User::where('user_id', $user->user_id)->with('roles')->first();
                    $userRole = $user_role->roles->first();

                    return response([
                        'user' => $user,
                        'roles' => $userRole,
                    ]);
                }
                
            }
            $user = User::where('user_id', $user->user_id)->with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi')->first();
                    $user_role = User::where('user_id', $user->user_id)->with('roles')->first();
                    $userRole = $user_role->roles->first();

                    return response([
                        'user' => $user,
                        'roles' => $userRole,
                    ]);
        }
        //burada da kullanıcının girdiği bilgiler hatalıysa hata verdiriyoruz
        elseif($user->hasRole('user'))
        {
            return response([
                'error_status' => '1',
                'message' => 'Email or Password is Incorrect. Or your e-mail is not verified yet!'
            ]);
        }
        
        else
        {
            return response([
                'error_status' => '1',
                'message' => 'Email or Password is Incorrect.The administrator did not approve your account. Or your e-mail is not verified yet!'
            ]);
        }

        $user = User::where('user_id', $user->user_id)->with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi')->first();
        $user_role = User::where('user_id', $user->user_id)->with('roles')->first();
        $userRole = $user_role->roles->first();

        return response([
            'user' => $user,
            'roles' => $userRole,
        ]);
        
    }

    public function token($token) {
        $user = User::where('rtoken', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Refresh token is invalid.'
            ]);
        }

        //refresh tokenın süresi geçmiş mi diye kontrol ediyoruz.
        if($user->rtoken_expired_at >= Carbon::parse(Carbon::now()) ) {
            //refresh tokenın süresi geçmemişse gerçek token süresini kontrol ediyoruz.
            //gerçek tokenın süresi geçmişse yeni token ve refresh token oluşturuyoruz        
            if($user->token_expired_at <= Carbon::parse(Carbon::now()) )
            {
                $token = bin2hex(random_bytes(20));
                $rtoken = bin2hex(random_bytes(20));

                User::findOrFail($user->user_id)->update([
                    'token' => $token,
                    'rtoken' => $rtoken,
                    'token_created_at' => Carbon::parse(Carbon::now()),
                    'token_expired_at' => Carbon::parse(Carbon::now()->addDay(1))->toDateTimeString(),
                    'rtoken_created_at' => Carbon::parse(Carbon::now()),
                    'rtoken_expired_at' => Carbon::parse(Carbon::now()->addMinutes(1500))->toDateTimeString(),
                ]);
                $user = User::where('user_id', $user->user_id)->first();
                return response([
                    $user
                ]);
            }
            //gerçek tokenın süresi geçmemişse aynı token kullanmaya devam edicek
            else
            {
                return response([
                    $user
                ]);
            }
        }
        //refresh tokenın süresi geçmişse tekrar giriş yapın diye hata mesajı yazdırıyoruz
        else {
            return response([
                'message' => 'Please login again!',
                'error_status' => '1',
            ]);
        }
    }


    public function showUser($token) {
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

        $user = User::where('token', $token)->select('user_id', 'name','username','email','phone','description','country','city','image')->with('Country', 'Citi', 'roles')->first();
        if($user->hasRole('user')) {
            return response([
                'userprofile' => $user,
            ]);
        }
        else 
        {
            return response([
                'error_status' => 1,
                'message' => 'You are not a user!'
            ]);
        }
    
        
    }

    public function UpdateUser(Request $request, $token){
        $user = User::where('token', $token)->first();
        $user_id = $user->user_id;
        
        // $rules = [
        //     'name' => 'required',
        //     'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|not_regex:/[a-z]/|min:9|max:15',
        //     'country' => 'required',
        //     'city' => 'required',
        //     'description' => 'required',
        // ];

        // if ($request->email != $user->email) {
        //     $rules['email'] = 'required|email|unique:tb_user';
        // }
        // if ($request->username != $user->username) {
        //     $rules['username'] = 'required|unique:tb_user';
        // }

        // $validator = Validator::make($request->all(), $rules);
        // if ($validator->fails()) {
        //     return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        // }

    
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        
        User::findOrFail($user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'country' => $request->country,
            'city' => $request->city,
            'description' => $request->description
        ]);
        $user = User::where('token', $token)->select('name', 'email', 'phone', 'username','country', 'city','description','image')->with('Country','Citi')->get();
        
        return response([
            'userprofile' => $user
        ]);

    }

    public function storeImage(Request $request, $token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'token is invalid.'
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
            Image::make($image)->save('upload/user_images/' . $name_gen);
            $save_url = 'upload/user_images/' . $name_gen;

            $user->image = $save_url;
            $user->save();
            
            $user_image = User::where('token', $token)->select('user_id', 'name', 'username','email','phone','description','country', 'city','image')->with('Country', 'Citi')->first();

            return response([
                'userprofile' => $user_image
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

    public function UserDetails($id) {
        $user = User::where('user_id', $id)->with('comments', 'Language', 'Activit', 'Country', 'UserImage','Citi', 'roles')->first();
        if(!$user) {
            return response([
                'error_status' => 1,
                'message' => 'User not found'
            ]);
        }

        $user->makeHidden(['token','token_created_at', 'token_expired_at', 'rtoken','rtoken_created_at', 'rtoken_expired_at','username','password','confirm_password','email', 'phone','last_seen','created_at','updated_at','is_approved','email_verified_at','is_email_verified','google_id','facebook_id','vkontakte_id']);
        
       

        return response([
            'user' => $user
        ]);
    }
}
