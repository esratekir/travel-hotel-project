<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Comments;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Guides;
use App\Models\User;

class CommentController extends Controller
{
    public function StoreComments(Request $request){
        if(Auth::check()){

            $guide= User::where('user_id', $request->guide_id)->first();
            if($guide) {
                Comments::create([
                    'comment' => $request->comment,
                    'guide_id' => $request->guide_id,
                    'user_id' => Auth::user()->user_id,
                    'comment_id' => $request->comment_id,
                    'created_at' => Carbon::now(),
                ]);
                $notification = array(
                    'message' => 'Your comment send successfully',
                    'alert-type' => 'success',
                );
                return redirect()->back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Rehber Bulunamadı',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
        }
        else 
        {
            $notification = array(
                'message' => 'Please login for comment',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function CommentsMessage($id){
        $comments = Comments::where('guide_id', '=', $id)->get();
        $user_name = User::where('user_id', '=', $id)->first();
        return view('backend.comments.all_comments',compact('comments', 'user_name'));
    }

    public function DeleteComments($id){
        Comments::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Mesaj Başarıyla Silindi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
