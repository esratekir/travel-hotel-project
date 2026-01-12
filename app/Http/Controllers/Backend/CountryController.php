<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Destination;
use Image;

class CountryController extends Controller
{
    public function AllDestination()
    {   
        $destination = Destination::latest()->get();
        return view('backend.countries.all_country', compact('destination'));
    }

    public function AddDestination()
    {
        return view('backend.countries.add_country');
    }

    public function StoreDestination(Request $request)
    {
        $validateData = $request->validate([
            'image'=> 'max:2000',
            'flag' => 'max:2000',
        ]);
        if ($request->file('image') || $request->file('flag')) {
            $image = $request->file('image');
            $flag = $request->file('flag');
            if ($image) {
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->save('upload/destination/' . $name_gen);
                $save_url = 'upload/destination/' . $name_gen;
            }
            if ($flag) {
                $name_gen = hexdec(uniqid()) . '.' . $flag->getClientOriginalExtension();
                Image::make($flag)->save('upload/destination/flags/' . $name_gen);
                $save_url2 = 'upload/destination/flags/' . $name_gen;
            }
        
            Destination::insert([
                'country' => $request->country,
                'image' => $save_url,
                'flag' => $save_url2,
            ]);

            $notification = [
                'message' => 'Ülke Başarıyla Eklendi',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.destination')->with($notification);
        } else {
            Destination::insert([
                'country' => $request->country,
            ]);

            $notification = [
                'message' => 'Ülke Başarıyla Eklendi',
                'alert-type' => 'success'
            ];
            return redirect()->route('all.destination')->with($notification);
        }
    }

    public function EditDestination($id)
    {
        $destination_id = Destination::findOrFail($id);
        return view('backend.countries.edit_country', compact('destination_id'));
    }

    public function UpdateDestination(Request $request)
    {
        $validateData = $request->validate([
            'image'=> 'max:2000',
            'flag' => 'max:2000',
        ]);
        
        $destination_id = $request->id;
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/destination/' . $name_gen);
            $save_url = 'upload/destination/' . $name_gen;

            Destination::findOrFail($destination_id)->update([
                'country' =>$request->country,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Ülke Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);
        } 
        elseif ($request->file('flag')) {
            $image = $request->file('flag');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();  //3434434.jpg şeklinde resmi adlandıracak burası

            Image::make($image)->save('upload/destination/flags/' . $name_gen);
            $save_url = 'upload/destination/flags/' . $name_gen;

            Destination::findOrFail($destination_id)->update([
                'country' =>$request->country,
                'flag' => $save_url,
            ]);
            $notification = array(
                'message' => 'Ülke Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);
        } else {
            Destination::findOrFail($destination_id)->update([
                'country' =>$request->country,
            ]);
            $notification = array(
                'message' => 'Ülke Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->route('all.destination')->with($notification);
        }
    }

    public function DeleteDestination($id)
    {
        $destination_id = Destination::findOrFail($id);
        // $img = $destination_id->image;
        // unlink($img);

        Destination::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Ülke Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.destination')->with($notification);
    }
}
