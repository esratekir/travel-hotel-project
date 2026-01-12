<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guides;
use App\Models\Languages;
use App\Models\Destination;
use App\Models\Comments;
use App\Models\GuideLanguage;
use App\Models\User;
use App\Models\UserImage;
use App\Models\Settings;
use App\Models\HomeKayitOl;
use Illuminate\Support\Facades\DB;
use App\Models\City;

class RehberController extends Controller
{
    public function GuidePage(Request $request) {
        $country = Destination::all();
        $query = User::query()->with('Language');
        $lang = Languages::where('id')->pluck('id');

        //burada bir dili kaç rehber biliyor onu hesapladık. withCount() ile relationship e sahip tabloların sütunlarının sayısını hesaplayailiyoruz.Blade'de kullanırken {{relation_adı_count}} şeklinde yazdırabiliriz
        $languages = Languages::withCount('guide_langu')->orderBy('language', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();
        
        $guide_image = UserImage::where('userid', '=', 'user_id')->get();
        $home_kayit = HomeKayitOl::find(1);
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
            $guides = $query->whereHas("roles", function($q){ $q->where("name", "guide"); })->whereIn('user_id',  $user_id_lang)->withCount('comments')->where('is_approved', '=', 1)->orderBy('comments_count', 'desc')->get();
        }
        else {
            $guides = $query->whereHas("roles", function($q){ $q->where("name", "guide"); })->withCount('comments')->where('is_approved', '=', 1)->orderBy('comments_count', 'desc')->get();
        }

        return view('frontend.pages.guides_page', compact('guides', 'country','languages', 'guide_image', 'home_kayit', 'cities'));
    }

    public function GuideDetails($username, User $id) {
        $user_id = User::where('username', $username)->pluck('user_id')->first();
        $guides = User::with('comments','Language', 'Activit','Country')->where('username', $username)->first();
        $activities = User::where('user_id', '=', $user_id)->get();
        $guide_images = UserImage::where('userid', '=', $user_id)->get();
        $settings= Settings::find(1);
        return view('frontend.pages.guides_details_page', compact('guides', 'activities', 'guide_images', 'settings'));
    }
}
