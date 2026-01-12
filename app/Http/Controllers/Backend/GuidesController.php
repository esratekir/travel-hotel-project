<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Guides;
use App\Models\GuideLanguage;
use App\Models\Destination;
use App\Models\Languages;
use Image;
use App\Models\Activity;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\City;
use App\Models\GuideActivity;
use Illuminate\Support\Facades\Hash;
use App\Models\UserImage;

class GuidesController extends Controller
{
    public function AllGuides()
    {
        $all_guides = User::whereHas("roles", function($q){ $q->where("name", "guide"); })->orderBy('user_id', 'DESC')->get();
        return view('backend.guides.all_guides', compact('all_guides'));
    }

    public function AddGuides()
    {
        $countries = Destination::orderBy('country', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();
        $languages = Languages::orderBy('language', 'ASC')->get();
        $activities = Activity::orderBy('activity_name', 'ASC')->get();
        return view('backend.guides.add_guides', compact('countries', 'languages', 'activities', 'cities'));
    }

    public function StoreGuides(Request $request)
    {   $request->validate([
            'username' => 'required|unique:tb_user',
            'email' => 'required',
            'phone' => 'required',
            'image' => 'max:2000',
        ]);
        $image = $request->file('image');
        $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->save('upload/guides/' . $name_gen);
        $save_url = 'upload/guides/' . $name_gen;
        
        $sonKayit = new  User([
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
            'image' => $save_url,
            'motto' => $request->motto,
            'is_approved' => 0,
        ]);
        
        $sonKayit->save();
       
        $sonKayit->syncRoles('guide');

        $languages = $request->language;
        foreach ($languages as $key => $value) {
            GuideLanguage::insert([
                'guide_id' => $sonKayit["user_id"],
               'language_id' => $value,
            ]);
        }

        $activity = $request->activities;
        foreach ($activity as $key => $value) {
            GuideActivity::insert([
                'guide_id' => $sonKayit["user_id"],
               'activity_id' => $value,
            ]);
        }

        $notification = array(
            'message' => 'Rehber Başarıyla Eklendi',
            'alert-type' => 'success'
        );
        return redirect()->route('all.guides')->with($notification);
    }

    public function EditGuides($id)
    {
        $guides_id = User::findOrFail($id);
        $countries = Destination::orderBy('country', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();
        $languages = Languages::orderBy('language', 'ASC')->get();
        $activiti = Activity::orderBy('activity_name', 'ASC')->get();
        $guide_lang = GuideLanguage::where('guide_id','=' ,$id)->get()->pluck('language_id')->toArray();
        $guide_act = GuideActivity::where('guide_id','=' ,$id)->get()->pluck('activity_id')->toArray();
        return view('backend.guides.edit_guides', compact('guides_id', 'countries', 'languages','guide_lang', 'cities', 'activiti', 'guide_act'));
    }

    public function UpdateGuides(Request $request)
    {
        $validateData = $request->validate([
            'image'=> 'max:2000',
        ]);
        $guides_id = $request->id;
        
        if ($request->file('image')) {
            $image = $request->file('image');
            $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/guides/' . $name_gen);
            $save_url = 'upload/guides/' . $name_gen;

             User::findOrFail($guides_id)->update([
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
                'image' => $save_url,
                'motto' => $request->motto,

            ]);

            $language = GuideLanguage::where('guide_id',"=", $guides_id)->get();
            foreach ($language as $key => $value) {
                GuideLanguage::findOrFail($value["id"])->delete();
            }
            
            $languages = $request->languages;
            
            foreach ($languages as $key => $value) {
                GuideLanguage::where('guide_id',"=", $guides_id)->insert([
                    'guide_id' => $guides_id,
                    'language_id' => $value,
                ]);
            }


            $activity = GuideActivity::where('guide_id',"=", $guides_id)->get();
            foreach ($activity as $key => $value) {
                GuideActivity::findOrFail($value["id"])->delete();
            }
            
            $activitis = $request->activities;
            
            foreach ($activitis as $key => $value) {
                GuideActivity::where('guide_id',"=", $guides_id)->insert([
                    'guide_id' => $guides_id,
                    'activity_id' => $value,
                ]);
            }

            
            $notification = array(
                'message' => 'Rehber Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.guides')->with($notification);
        } else {
            User::findOrFail($guides_id)->update([
                
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

            ]);

            $language = GuideLanguage::where('guide_id',"=", $guides_id)->get();
            foreach ($language as $key => $value) {
                GuideLanguage::findOrFail($value["id"])->delete();
            }
            
            $languages = $request->languages;
            foreach ($languages as $key => $value) {
                GuideLanguage::where('guide_id',"=", $guides_id)->insert([
                    'guide_id' => $guides_id,
                    'language_id' => $value,
                ]);
            }

            $activity = GuideActivity::where('guide_id',"=", $guides_id)->get();
            foreach ($activity as $key => $value) {
                GuideActivity::findOrFail($value["id"])->delete();
            }
            
            $activitis = $request->activities;
            
            foreach ($activitis as $key => $value) {
                GuideActivity::where('guide_id',"=", $guides_id)->insert([
                    'guide_id' => $guides_id,
                    'activity_id' => $value,
                ]);
            }
            
            $notification = array(
                'message' => 'Rehber Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.guides')->with($notification);
        }
    }

    public function ApproveGuides($id) {
        $guide_id = User::findOrFail($id);
        $guide_id->is_approved = 1;
        $guide_id->save();
        return redirect()->back();
    }

    public function DeclineGuides($id) {
        $guide = User::findOrFail($id);
        $guide->is_approved = 0;
        $guide->save();

        $guide_language = GuideLanguage::where('guide_id','=' ,$id)->get();
        foreach($guide_language as $key=>$value){
            GuideLanguage::findOrFail($value["id"])->delete();
        }

        $guide_activity = GuideActivity::where('guide_id','=' ,$id)->get();
        foreach($guide_activity as $key=>$value){
            GuideActivity::findOrFail($value["id"])->delete();
        }

        $guide_image = UserImage::where('userid','=' ,$id)->get();
        foreach($guide_image as $key=>$value){
            UserImage::findOrFail($value["id"])->delete();
        }
        
        $img = $guide->image;
        if(file_exists($img)){
            unlink($img);
        }

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Rehber Başarıyla Reddedildi',
            'alert-type' => 'success'
        );
        return redirect()->back();
    }

    public function DeleteGuides($id)
    {
        $guide_id = User::findOrFail($id);
        
        $guide_language = GuideLanguage::where('guide_id','=' ,$id)->get();
        foreach($guide_language as $key=>$value){
            GuideLanguage::findOrFail($value["id"])->delete();
        }

        $guide_activity = GuideActivity::where('guide_id','=' ,$id)->get();
        foreach($guide_activity as $key=>$value){
            GuideActivity::findOrFail($value["id"])->delete();
        }

        $guide_image = UserImage::where('userid','=' ,$id)->get();
        foreach($guide_image as $key=>$value){
            UserImage::findOrFail($value["id"])->delete();
        }
        
        $img = $guide_id->image;
        if(file_exists($img)){
            unlink($img);
        }

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Rehber Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.guides')->with($notification);
    }
}
