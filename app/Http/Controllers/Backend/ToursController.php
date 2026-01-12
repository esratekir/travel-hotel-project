<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Turlar;
use Image;
use App\Models\Destination;
use App\Models\TourProgram;
class ToursController extends Controller
{
    public function AllTours()
    {
        $all_tours = Turlar::latest()->get();
        return view('backend.tours.all_tours', compact('all_tours'));
    }

    public function AddTours()
    {
        $countries = Destination::orderBy('title', 'ASC')->get();
        return view('backend.tours.add_tours', compact('countries'));
    }

    public function StoreTours(Request $request)
    {
        $validateData = $request->validate([
            'image'=> 'max:2000',
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

        Image::make($image)->save('upload/tours/' . $name_gen);
        $save_url = 'upload/tours/' . $name_gen;

        Turlar::insert([
            'tour_title' => $request->tour_title,
            'country' => $request->country,
            'day' => $request->day,
            'person' => $request->person,
            'price' => $request->price,
            'fiyat_dahil' => $request->fiyat_dahil,
            'fiyat_dahil_degil' => $request->fiyat_dahil_degil,
            'kisi_basi' => $request->kisi_basi,
            'tur_tarihi' => $request->tur_tarihi,
            'cift_kisilik_oda' => $request->cift_kisilik_oda,
            'ilave_yatak' => $request->ilave_yatak,
            'image' => $save_url,
        ]);

        $notification = array(
            'message' => 'Tur Başarıyla Eklendi',
            'alert-type' => 'success'
        );

        return redirect()->route('edit.tours', ['id' => 1])->with($notification);
    }

    public function EditTours($id)
    {
        $tours_id = Turlar::findOrFail($id);
        $countries = Destination::orderBy('title', 'ASC')->get();
        return view('backend.tours.edit_tours', compact('tours_id', 'countries'));
    }

    public function UpdateTours(Request $request)
    {
        $validateData = $request->validate([
            'image'=> 'max:2000',
        ]);
        $tour_id = $request->id;
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
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/tours/' . $name_gen);
            $save_url = 'upload/tours/' . $name_gen;

            Turlar::findOrFail($tour_id)->update([
                'tour_title' => $request->tour_title,
                'country' => $request->country,
                'day' => $request->day,
                'person' => $request->person,
                'price' => $request->price,
                'fiyat_dahil' => $request->fiyat_dahil,
                'fiyat_dahil_degil' => $request->fiyat_dahil_degil,
                'kisi_basi' => $request->kisi_basi,
                'tur_tarihi' => $request->tur_tarihi,
                'cift_kisilik_oda' => $request->cift_kisilik_oda,
                'ilave_yatak' => $request->ilave_yatak,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Tur Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.tours')->with($notification);
        } else {
            Turlar::findOrFail($tour_id)->update([
                'tour_title' => $request->tour_title,
                'country' => $request->country,
                'day' => $request->day,
                'person' => $request->person,
                'price' => $request->price,
                'fiyat_dahil' => $request->fiyat_dahil,
                'fiyat_dahil_degil' => $request->fiyat_dahil_degil,
                'kisi_basi' => $request->kisi_basi,
                'tur_tarihi' => $request->tur_tarihi,
                'cift_kisilik_oda' => $request->cift_kisilik_oda,
                'ilave_yatak' => $request->ilave_yatak,
            ]);
            $notification = array(
                'message' => 'Tur Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.tours')->with($notification);

        }
    }

    public function ProgramTours($id)
    {   
        $tours_id = Turlar::findOrFail($id);
        $countries = TourProgram::where('tour_id', "=", $id)->get();
        return view('backend.tours.program_tours', compact('tours_id', 'countries'));
        
    }

    public function UpdateProgramTours(Request $request) {
        
        $countries = TourProgram::where('tour_id', "=", $request->id)->get();
        foreach ($countries as $key => $value) {
            TourProgram::findOrFail($value["id"])->delete();
        }

        $days = $request->day;
        
        foreach ($days as $key => $value) {
            TourProgram::insert([
                'tour_id' => $request->id,
                'tour_day' => $value,
                'tour_detail' => $request->detail[$key],
            ]);
        }

        $notification = array(
            'message' => 'Tur Programı Başarıyla Eklendi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.tours')->with($notification);

    }

    public function DeleteTours($id)
    {
        $tour_id = Turlar::findOrFail($id);
        $img = $tour_id->image;
        unlink($img);

        Turlar::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Tur Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.tours')->with($notification);
    }
}
