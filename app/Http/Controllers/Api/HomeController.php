<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeCard;
use App\Models\User;
use App\Models\Clients;
use App\Models\Activity;
use App\Models\Languages;
use App\Models\Destination;
use App\Models\City;

class HomeController extends Controller
{
    public function HomeServices() {
        $home_card = HomeCard::all();
        return response([
            $home_card
        ]);
    }

    public function HomeGuides() {
        $guides = User::whereHas("roles", function($q) {
            $q->where("name", "guide");
        })->withCount('comments')
          ->having('comments_count', '>', 5)
          ->where('is_approved', '=', 1)
          ->orderBy('comments_count', 'desc')
          ->with('Language','Country','Citi')
          ->take(8)
          ->get()
          ->makeHidden(['token', 'rtoken', 'token_created_at', 'token_expired_at', 'rtoken_created_at', 'rtoken_expired_at','password','confirm_password']);
        
        return response([
            $guides,
        ]);
        
    }

    public function HomeClients() {
        $clients = Clients::take(6)->get();

        return response([
            $clients
        ]);
    }

    public function Activities() {
        $activities = Activity::latest()->get();
        return response([
            'activities' => $activities,
        ]);
    }

    public function Languages() {
        $language = Languages::get();
        return response([
            'languages' => $language,
        ]);
    }

    public function Countries() {
        $countries = Destination::get();
        return response([
            'countries' => $countries,
        ]);
    }

    public function Cities() {
        $cities = City::get();
        return response([
            'cities' => $cities,
        ]);
    }
}
