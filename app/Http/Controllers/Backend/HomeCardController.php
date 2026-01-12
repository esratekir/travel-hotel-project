<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeCard;

class HomeCardController extends Controller
{
    public function AllHomeCard(){

        $home_cards = HomeCard::latest()->get();
        return view('backend.home_card.home_card_all',compact('home_cards')); 

    }

    public function AddHomeCard(){

        return view('backend.home_card.home_card_add');
    }

    public function StoreHomeCard(Request $request){

        HomeCard::insert([
            'card_icon' => $request->card_icon,
            'mobile_icon' => $request->mobile_icon,
            'card_title' => $request->card_title,
            'card_subtitle' => $request->card_subtitle,
        ]);

        $notification = array(
            'message' => 'Hizmet Başarıyla Eklendi',
            'alert-type' => 'success'
        );

        return redirect()->route('all.home.card')->with($notification);

    }

    public function EditHomeCard($id){

        $card_id = HomeCard::findOrFail($id);
        return view('backend.home_card.edit_home_card',compact('card_id'));
    }

    public function UpdateHomeCard(Request $request,$id){
        $card_id = $request->id;
        HomeCard::findOrFail($id)->update([
            'card_icon' => $request->card_icon,
            'mobile_icon' => $request->mobile_icon,
            'card_title' => $request->card_title,
            'card_subtitle' => $request->card_subtitle,
        ]);

        $notification = array(
            'message' => 'Hizmet Başarıyla Güncellendi',
            'alert-type' => 'success'
        );
        return redirect()->route('all.home.card')->with($notification);
    }

    public function DeleteHomeCard($id){

        HomeCard::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Hizmet Başarıyla Silindi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
