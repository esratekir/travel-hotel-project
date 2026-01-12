<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyTrip;
use Illuminate\Support\Facades\Auth;
use App\Models\Destination;
use App\Models\City;

class TripController extends Controller
{
    public function TripsPage() {
        $id = Auth::user()->user_id;    //hangi id girdiyse admin panele onun idsini bulur
        $userData = MyTrip::where('guide_id', '=', $id)->orderBy('id', 'desc')->get();
       
        $city = City::get();
        $data = City::whereNotNull('country_id')->get();
        
        return view('frontend.pages.my_trips', compact('userData', 'city', 'data'));
    }

    public function UpdateTrips(Request $request) {
        MyTrip::insert([
            'guide_id' => Auth::user()->user_id,
            'destination' => $request->destination,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'number_of' => $request->number_of,
            'local_type' => json_encode($request->local_type),
        ]);

        $notification = array(
            'message' => 'Your trip created successfully.',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function DeleteTrips($id) {
        MyTrip::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Your trip deleted successfully!',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function ViewTrips() {
        $countri = Auth::user()->city; 
        $trips = MyTrip::where('destination', '=', $countri)->orderBy('id', 'desc')->get();
      
        return view('frontend.pages.view_trips', compact('trips', 'countri'));

    }


}
