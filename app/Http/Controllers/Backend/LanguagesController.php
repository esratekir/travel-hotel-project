<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Languages;
use App\Models\Destination;
use Image;

class LanguagesController extends Controller
{
    public function AllLanguages(){
        $languages = Languages::latest()->get();
        return view('backend.languages.all_languages',compact('languages'));
    }

    public function AddLanguages(){
        return view('backend.languages.add_languages');
    }

    public function StoreLanguages(Request $request){
        $validateData = $request->validate([
            'flag'=> 'max:2000',
        ]);
        if($request->file('flag')){
            $image = $request->file('flag');
            $extension = $request->file('flag')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->save('upload/languages/'.$name_gen);
            $save_url = 'upload/languages/'.$name_gen;

            Languages::insert([
                'language' => $request->language,
                'flag_icon' => $request->flag_icon,
                'flag' => $save_url,
            ]);

            $notification = array(
                'message' => 'Dil Başarıyla Eklendi',
                'alert-type' => 'success'
            );

            return redirect()->route('all.languages')->with($notification);
        }
        else {
            Languages::insert([
                'language' => $request->language,
                'flag_icon' => $request->flag_icon,
    
            ]);
    
            $notification = array(
                'message' => 'Dil Başarıyla Eklendi',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.languages')->with($notification);
        }
        

    }

    public function EditLanguages($id){
        $language_id = Languages::findOrFail($id);
        return view('backend.languages.edit_languages',compact('language_id'));
    }

    public function UpdateLanguages(Request $request){
        $validateData = $request->validate([
            'flag'=> 'max:2000',
        ]);
        $language_id = $request->id;

        if($request->file('flag')){
            $image = $request->file('flag');
            $extension = $request->file('flag')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/languages/'.$name_gen);
            $save_url = 'upload/languages/'.$name_gen;

            Languages::findOrFail($language_id)->update([
                'language' => $request->language,
                'flag_icon' => $request->flag_icon,
                'flag' => $save_url,
            ]);
            $notification = array(
                'message' => 'Dil Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.languages')->with($notification);
        }
        else {
            Languages::findOrFail($language_id)->update([
                'language' => $request->language,
                'flag_icon' => $request->flag_icon,
            ]);
    
            $notification = array(
                'message' => 'Dil Başarıyla Güncellendi',
                'alert-type' => 'success',
            );
    
            return redirect()->route('all.languages')->with($notification);
        }

        
    }

    public function DeleteLanguages($id){
        Languages::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Dil Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.languages')->with($notification);
    }
}
