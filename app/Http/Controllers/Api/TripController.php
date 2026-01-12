<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyTrip;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;


class TripController extends Controller
{
    public function CreateTrip(Request $request, $token) {
        $user = User::where('token', $token)->first();

        $rules = [
            'destination' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
            'number_of' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'hatadurumu' => 1]);
        }

        if(!$user) {
            return response([
                'hatadurumu' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'hatadurumu' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $trip = MyTrip::insert([
            'guide_id' => $user->user_id,
            'destination' => $request->destination,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'number_of' => $request->number_of,
            'local_type' => $request->local_type,
        ]);
        $trip = MyTrip::where('guide_id', $user->user_id)->with('citi')->orderBy('id', 'desc')->get();
        
        return response([
            'trip' => $trip
        ]);
    }

    public function UserTrips($token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'hatadurumu' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'hatadurumu' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $trips = MyTrip::where('guide_id', $user->user_id)->with('Destinati', 'user','citi')->orderBy('id','desc')->get();

        $filteredData = [];

            foreach ($trips as $trip) {
                $tripId = $trip->id;
                $userId = $trip->user->user_id;
                $userName = $trip->user->name;
                $userImage = $trip->user->image;
                $userCity = $trip->citi;
                $userCountry = $trip->citi->country;
                $tripdate_from = $trip->date_from;
                $tripdate_to = $trip->date_to;
                $number_of = $trip->number_of;
                $user_role = $trip->user->roles;
                // $local_type = $trip->local_type;

                // İstenilen değerleri bir diziye ekleyin
                $filteredData[] = [
                    'trip_id' => $tripId,
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'user_image' => $userImage,
                    'city' => $userCity,
                    'country' => $userCountry,
                    'tripdate_from' => $tripdate_from,
                    'tripdate_to' => $tripdate_to,
                    'number_of_people' => $number_of,
                    'roles' => $user_role,
                ];
            }

            $trip = MyTrip::where('destination', '=', $user->user_id)->with('citi')->orderBy('id', 'desc')->get();
            
            return Response::json(['my_trips' => $filteredData]);
    }

    public function DeleteTrip($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'hatadurumu' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_id = MyTrip::find($id);
        if(!$requested_id) {
            return response([
                'hatadurumu' => '1',
                'message' => 'This trip doesnt exist.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'hatadurumu' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        MyTrip::findOrFail($id)->delete();
        return response([
            'message' => 'Trip deleted successfully.'
        ]);
    }

    public function ViewTrip($token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()))
        {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again!'
            ]);
        }

        $countri = $user->city;
        if($user->hasRole('guide')) {
            $trips = MyTrip::where('destination', '=', $countri)->orderBy('id', 'desc')->with('Destinati', 'user','citi')->get();

            $filteredData = [];

            foreach ($trips as $trip) {
                $userId = $trip->user->user_id;
                $userName = $trip->user->name;
                $userImage = $trip->user->image;
                $userCity = $trip->user->Citi;
                $userCountry = $trip->user->Country;
                $tripdate_from = $trip->date_from;
                $tripdate_to = $trip->date_to;
                $number_of = $trip->number_of;
                $user_role = $trip->user->roles;
                // $local_type = $trip->local_type;

                // İstenilen değerleri bir diziye ekleyin
                $filteredData[] = [
                    'user_id' => $userId,
                    'user_name' => $userName,
                    'user_image' => $userImage,
                    'city' => $userCity,
                    'country' => $userCountry,
                    'tripdate_from' => $tripdate_from,
                    'tripdate_to' => $tripdate_to,
                    'number_of_people' => $number_of,
                    'roles' => $user_role,
                ];
            }

            $trip = MyTrip::where('destination', '=', $countri)->with('citi')->orderBy('id', 'desc')->get();
            
            return Response::json(['my_trips' => $filteredData]);
        }
        else
        {
            return response([
                'error_status' => 1,
                'message' => 'User is not a guide!'
            ]);
        }
        

    }
}
