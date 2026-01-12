<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class FavoritesController extends Controller
{
    public function AddFavorites($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => 1,
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_user = User::findOrFail($id);
        if(!$requested_user) {
            return response([
                'error_status' => 1,
                'message' => 'Guide not found'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again!'
            ]);
        }

        Favorite::create([
            'user_id' => $user->user_id,
            'guide_id' => $id,
        ]);

        return response([
            'message' => 'Guide added to your favorites successfully'
        ]);

    }

    public function MyFavorites($token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => 1,
                'message' => 'Token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again!'
            ]);
        }

        // $my_favorites = Favorite::where('user_id', $user->user_id)->with('favoriGuide')->get();
        // return response([
        //     $my_favorites,
        // ]);

        $my_favorites = Favorite::where('user_id', $user->user_id)->with('favoriGuide')->orderBy('id','desc')->get();

        $filteredData = [];

        foreach ($my_favorites as $favorite) {
            // İlgili favoriGuide ilişkisinden istediğiniz değerlere ulaşın
            $guideName = $favorite->favoriGuide->name;
            $guideCity = $favorite->favoriGuide->Citi;
            $guideCountry = $favorite->favoriGuide->Country;
            $guideImage = $favorite->favoriGuide->image;
            $guideLanguages = $favorite->favoriGuide->Language;
            $guideRole = $favorite->favoriGuide->roles;
            $guidePrice = $favorite->favoriGuide->price;
            $guideId = $favorite->favoriGuide->user_id;
            $favoriteId = $favorite->id;
            // İstenilen değerleri bir diziye ekleyin
            $filteredData[] =  [
                'favorite_id' => $favoriteId,
                'user_id' => $guideId,
                'guide_name' => $guideName,
                'guide_city' => $guideCity,
                'guide_country' => $guideCountry,
                'price' => $guidePrice,
                'guide_image' => $guideImage,
                'guide_role' => $guideRole,
                'guide_languages' => $guideLanguages
            ];
        }

      
        return Response::json(['favorites' => $filteredData]);
    }

    public function DeleteFavorites($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => 1,
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_user = Favorite::findOrFail($id);
        if(!$requested_user) {
            return response([
                'error_status' => 1,
                'message' => 'Favorite not found'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again!'
            ]);
        }

        Favorite::findOrFail($id)->delete();
        return response([
            'message' => 'Guide has been successfully removed from favorites '
        ]);
    }
}
