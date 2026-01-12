<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MyTrip;

class MyTripController extends Controller
{
    public function TripsAll(){
        $trips = MyTrip::orderBy('id', 'desc')->get();
        return view('backend.trips.trips_all',compact('trips'));
    }

    public function DeleteTrips($id) {
        MyTrip::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Trip başarıyla silindi.',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
}
