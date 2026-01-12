<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\HomeKayitOl;
use Image;

class HomeKayitController extends Controller
{
    public function HomeKayit(){
        $home_kayit = HomeKayitOl::find(1);
        return view('backend.home_kayit.home_kayit_all',compact('home_kayit'));
    }

    public function UpdateHomeKayit(Request $request){
        $validateData = $request->validate([
            'image'=> 'max:2000',
        ]);
        $home_kayit_id = $request->id;
        if($request->file('image')){
            $image = $request->file('image');
            $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
           

            Image::make($image)->save('upload/home_kayit/'.$name_gen);
            $save_url = 'upload/home_kayit/'.$name_gen;

            HomeKayitOl::findOrFail($home_kayit_id)->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Rehber Kayıt Başarıyla Güncellendi',
                'alert-type' => 'success',
            );

            return redirect()->back()->with($notification);
        }
        else {
            HomeKayitOl::findOrFail($home_kayit_id)->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
            ]);

            $notification = array(
                'message' => 'Rehber Kayıt Başarıyla Güncellendi',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }
    }
}
