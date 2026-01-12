<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Destination;
use Image;

class DestinationController extends Controller
{
    public function AllDestination() {
        
        $destination = Destination::latest()->get();
        return view('backend.home_destinations.all_destination',compact('destination'));
    }

    public function AddDestination(){
        return view('backend.home_destinations.add_destination');
    }

    public function StoreDestination(Request $request){
        if($request->file('image')){
            $image = $request->file('image');
            $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Logo dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/destination/'.$name_gen);
            $save_url = 'upload/destination/'.$name_gen;

            Destination::insert([
                'country' =>$request->country,
                'state' =>$request->state,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Ülke Başarıyla Eklendi',
                'alert-type' => 'success'
            );

            return redirect()->route('all.destination')->with($notification);

        }
        elseif($request->file('flag')){
            $image = $request->file('flag');
            $extension = $request->file('flag')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Logo dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->save('upload/destination/flags/'.$name_gen);
            $save_url = 'upload/destination/flags/'.$name_gen;

            Destination::insert([
                'country' =>$request->country,
                'state' =>$request->state,
                'flag' => $save_url,
            ]);

            $notification = array(
                'message' => 'Ülke Başarıyla Eklendi',
                'alert-type' => 'success'
            );

            return redirect()->route('all.destination')->with($notification);
        }
        else {
            Destination::insert([
                'country' =>$request->country,
                'state' =>$request->state,
            ]);

            $notification = array(
                'message' => 'Ülke Başarıyla Eklendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);
        }
        
    }

    public function EditDestination($id){
        $destination_id = Destination::findOrFail($id);
        return view('backend.home_destinations.edit_destination',compact('destination_id'));
    }

    public function UpdateDestination(Request $request) {

        $destination_id = $request->id;
        if($request->file('image')) {
            $image = $request->file('image');
            $extension = $request->file('image')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Logo dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/destination/'.$name_gen);
            $save_url = 'upload/destination/'.$name_gen;

            Destination::findOrFail($destination_id)->update([
                'country' =>$request->country,
                'state' =>$request->state,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Ülke Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);
        }
        elseif($request->file('flag')){
            $image = $request->file('flag');
            $extension = $request->file('flag')->extension();
            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $notification = array(
                    'message' => 'Logo dosya uzantısı sadece jpg,png,jpeg olmalı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/destination/flags/'.$name_gen);
            $save_url = 'upload/destination/flags/'.$name_gen;

            Destination::findOrFail($destination_id)->update([
                'country' =>$request->country,
                'state' =>$request->state,
                'flag' => $save_url,
            ]);
            $notification = array(
                'message' => 'Ülke Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);
        }
        else {
            Destination::findOrFail($destination_id)->update([
                'country' =>$request->country,
                'state' =>$request->state,
            ]);
            $notification = array(
                'message' => 'Ülke Başarıyla Güncelendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);

        }

    }

    public function DeleteDestination($id) {
        $destination_id = Destination::findOrFail($id);
        // $img = $destination_id->image;
        // unlink($img);

        Destination::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Ülke Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.destination')->with($notification);
    }
}
