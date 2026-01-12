<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Destination;

class CityController extends Controller
{
    public function AllCities()
    {
        $city = City::latest()->get();
        return view('backend.cities.all_city', compact('city'));
    }

    public function AddCities() {
        $countries = Destination::orderBy('country', 'ASC')->get();
        return view('backend.cities.add_city', compact('countries'));
    }

    public function StoreCities(Request $request) {
        City::insert([
            'country_id' =>$request->country,
            'name' =>$request->name,
        ]);

        $notification = array(
            'message' => 'Şehir Başarıyla Eklendi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.cities')->with($notification);
    }

    public function EditCities($id) {
        $city_id = City::findOrFail($id);
        $countries = Destination::orderBy('country', 'ASC')->get();
        return view('backend.cities.edit_city', compact('city_id', 'countries'));
    }

    public function UpdateCities(Request $request) {
        $city_id = $request->id;
        City::findOrFail($city_id)->update([
            'country_id' =>$request->country,
            'name' =>$request->name,
        ]);
        $notification = array(
            'message' => 'Şehir Başarıyla Güncellendi',
            'alert-type' => 'success'
        );
        return redirect()->route('all.cities')->with($notification);
    }

    public function DeleteCities($id) {
        City::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Şehir Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.cities')->with($notification);
    }
}
