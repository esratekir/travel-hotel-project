<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserImage;
use App\Models\User;
use Image;
use Illuminate\Support\Carbon;

class UserImagesController extends Controller
{
    public function AllImages($id) {
        $user_images = UserImage::where('userid', '=', $id)->get();
        $user_name = User::where('user_id', '=', $id)->first();
        return view('backend.guides_images.all_images', compact('user_images', 'user_name'));
    }

    public function AddImages($id) {
        $user_name = User::where('user_id', '=', $id)->first();
        $users = User::where('user_id', '=', $id)->orderBy('name', 'ASC')->whereHas("roles", function($q){ $q->where("name", "guide"); })->get();
        return view('backend.guides_images.add_images', compact('users', 'user_name'));
    }

    public function StoreImages(Request $request) {
        $validateData = $request->validate([
            'image.*'=> 'max:2000',
        ]);
        $image = $request->file('image');
        foreach ($image as $user_image) {
            $name_gen = hexdec(uniqid()).'.'.$user_image->getClientOriginalExtension();

            Image::make($user_image)->save('upload/user_gallery/'.$name_gen);
            $save_url = 'upload/user_gallery/'.$name_gen;

            UserImage::insert([
                'userid' => $request->guide,
                'image' => $save_url,
                'created_at' => Carbon::now()
            ]);
        } //end of the foreach

        $notification = array(
            'message' => 'Rehber Resmi Başarıyla Eklendi',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function EditImages($id) {
        $user_image_id = UserImage::findOrFail($id);
        $users = User::orderBy('name', 'ASC')->whereHas("roles", function($q){ $q->where("name", "guide"); })->get();
        return view('backend.guides_images.edit_images', compact('user_image_id', 'users'));
    }

    public function UpdateImages(Request $request) {
        $validateData = $request->validate([
            'image'=> 'max:2000',
        ]);
        $user_image_id = $request->id;
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

            Image::make($image)->save('upload/user_gallery/'.$name_gen);
            $save_url = 'upload/user_gallery/'.$name_gen;

            UserImage::findOrFail($user_image_id)->update([
                'userid' => $request->guide,
                'image' => $save_url,
            ]);
            $notification = array(
                'message' => 'Rehber Resimleri Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }

        else 
        {
            UserImage::findOrFail($user_image_id)->update([
                'userid' => $request->guide,
            ]);
            $notification = array(
                'message' => 'Rehber Resimleri Başarıyla Güncellendi',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function DeleteImages($id) {
        $room_image_id = UserImage::findOrFail($id);
        $img = $room_image_id->image;
        unlink($img);

        UserImage::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Rehber Resmi Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
