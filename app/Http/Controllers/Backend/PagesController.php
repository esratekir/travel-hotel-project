<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\PageHome;
use App\Models\PageTour;
use App\Models\PageGuide;
use App\Models\PageContact;
use Image;

class PagesController extends Controller
{
    public function Pages(){
        return view('backend.pages.all_pages');
    }

    public function PagesHome(){
        $pageshome = PageHome::find(1);
        return view('backend.pages.home_pages',compact('pageshome'));
    }

    public function UpdatePagesHome(Request $request) {
        $home_id = $request->id;

        PageHome::findOrFail($home_id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'keywords' => $request->keywords,

        ]);
        $notification = array(
            'message' => 'Anasayfa Başarıyla Güncellendi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function PagesTour(){
        $pagestour = PageTour::find(1);
        return view('backend.pages.tour_pages',compact('pagestour'));
    }

    public function UpdatePagesTour(Request $request) {
        $validateData = $request->validate([
            'page_banner'=> 'max:2000',
        ]);
        $tour_id = $request->id;

        if($request->file('page_banner')){
            $image = $request->file('page_banner');
            $extension = $request->file('page_banner')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        
            Image::make($image)->save('upload/pages/'.$name_gen);
            $save_url = 'upload/pages/'.$name_gen;

            PageTour::findOrFail($tour_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'keywords' => $request->keywords,
                'page_banner' => $save_url,
                
            ]);

            $notification = array(
                'message' => 'Tur Sayfası Başarıyla Güncellendi',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        }
        else {
            PageTour::findOrFail($tour_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'keywords' => $request->keywords,
                
            ]);

            $notification = array(
                'message' => 'Tur Sayfası Başarıyla Güncellendi',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);
        }

    }

    public function PagesGuide(){
        $pagesguide = PageGuide::find(1);
        return view('backend.pages.guide_pages', compact('pagesguide'));
    }

    public function UpdatePagesGuide(Request $request){
        $validateData = $request->validate([
            'page_banner'=> 'max:2000',
        ]);
        $guide_id = $request->id;
        if($request->file('page_banner')){
            $image = $request->file('page_banner');
            $extension = $request->file('page_banner')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/pages/'.$name_gen);
            $save_url = 'upload/pages/'.$name_gen;

            PageGuide::findOrFail($guide_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'keywords' => $request->keywords,
                'page_banner' => $save_url,
            ]);
            $notification = array(
                'message' => 'Rehber Sayfası Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        else{
            PageGuide::findOrFail($guide_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'keywords' => $request->keywords,
            ]);
            $notification = array(
                'message' => 'Rehber Sayfası Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    

    public function PagesContact(){
        $pagescontact = PageContact::find(1);
        return view('backend.pages.contact_pages', compact('pagescontact'));
    }

    public function UpdatePagesContact(Request $request){
        $validateData = $request->validate([
            'page_banner'=> 'max:2000',
        ]);
        $contact_id = $request->id;
        if($request->file('page_banner')){
            $image = $request->file('page_banner');
            $extension = $request->file('page_banner')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Resmin dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/pages/'.$name_gen);
            $save_url = 'upload/pages/'.$name_gen;

            PageContact::findOrFail($contact_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'keywords' => $request->keywords,
                'page_banner' => $save_url,
            ]);
            $notification = array(
                'message' => 'İletişim Sayfası Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
        else{
            PageContact::findOrFail($contact_id)->update([
                'title' => $request->title,
                'description' => $request->description,
                'keywords' => $request->keywords,
            ]);
            $notification = array(
                'message' => 'İletişim Sayfası Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

}
