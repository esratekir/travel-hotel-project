<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
class ActivityController extends Controller
{
    public function AllActivity(){
        $activities = Activity::latest()->get();
        return view('backend.activity.all_activity',compact('activities'));
    }

    public function AddActivity(){
        
        return view('backend.activity.add_activity');
    }

    public function StoreActivity(Request $request){
        
        Activity::insert([
            'activity_name' => $request->activity_name,
            'icon' => $request->icon,
            'mobile_icon' => $request->mobile_icon,
        ]);

        $notification = array(
            'message' => 'Aktivite Başarıyla Eklendi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.activity')->with($notification);

    }

    public function EditActivity($id){
        $activity_id = Activity::findOrFail($id);
        return view('backend.activity.edit_activity',compact('activity_id'));
    }

    public function UpdateActivity(Request $request){
        $activity_id = $request->id;

        Activity::findOrFail($activity_id)->update([
            'activity_name' => $request->activity_name,
            'icon' => $request->icon,
            'mobile_icon' => $request->mobile_icon,
        ]);

        $notification = array(
            'message' => 'Aktivite Başarıyla Güncellendi',
            'alert-type' => 'success',
        );

        return redirect()->route('all.activity')->with($notification);
    }

    public function DeleteActivity($id){
        Activity::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Aktivite Başarıyla Silindi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.activity')->with($notification);
    }
}
