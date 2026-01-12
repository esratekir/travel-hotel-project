<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSlide;
use App\Models\HomeKayitOl;
use App\Models\HomeCard;
use App\Models\Clients;
use App\Models\Guides;
use App\Models\Turlar;
use App\Models\Destination;
use App\Models\Languages;
use App\Models\User;
use App\Models\GuideLanguage;
use App\Models\City;
use App\Models\Comments;

class HomeController extends Controller
{
    public function Index(Request $request) {

        $slider = HomeSlide::all();
        //$destination = Destination::limit(6)->get();
        $home_kayit = HomeKayitOl::find(1);
        $home_card = HomeCard::all();
        $languages = Languages::withCount('guide_langu')->orderBy('language', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();
        
        $country = Destination::all();
        $query_lang = GuideLanguage::query();
        $query = User::query();
        
        // $max_reviews = Comments::max('guide_id')->withCount();
        // dd($max_reviews_count);

        // $max_reviews = User::with('comments')->get()->sortBy(function($max_reviews){return $max_reviews->comments->count(); });

        $guide_comment = User::withCount('comments')->orderByDesc('comments_count')->first();
        $mostComments = $guide_comment->comments_count; //burası bir rehbere gelen en fazla yorum sayısını veriyor
        //dd($mostComments-5);

        $guides = $query->whereHas("roles", function($q){ $q->where("name", "guide"); })->withCount('comments')->having('comments_count', '>', 5)->where('is_approved', '=', 1)->orderBy('comments_count', 'desc')->take(8)->get();
        $guide_lang = $query_lang->get();
        $clients = Clients::take(6)->get();
        $tours = Turlar::take(6)->get();
        $guide_languages= GuideLanguage::select('language_id')->groupBy('language_id')->count();
        
        return view('frontend.index', compact('slider','home_kayit','languages','country','guides','tours','home_card','clients', 'guide_languages', 'cities'));
    }

    public function TermsofUse() {
        return view('frontend.links.termsof_use');
    }

    public function PrivacyPolicy() {
        return view('frontend.links.privacy_policy');
    }

    public function Cookies() {
        return view('frontend.links.cookies');
    }

    public function Security() {
        return view('frontend.links.securitys');
    }

}
