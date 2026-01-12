<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class CommentsController extends Controller
{
    public function GetComments($id) {
        $user = User::where('user_id', $id)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'User is undefinded.'
            ]);
        }

        // $id = User::where('token', $token)->pluck('user_id');
        $comments = Comments::where('guide_id', '=', $id)->orderBy('id', 'desc')->with('user')->get();

        if($comments->isEmpty()) {
            return response([
                'message' => 'You dont have any comments yet.'
            ]);
        }

        $filteredData = [];

        foreach ($comments as $comment) {
            // İlgili favoriGuide ilişkisinden istediğiniz değerlere ulaşın
            $userName = $comment->user->name;
            $userImage = $comment->user->image;
            $userRole = $comment->user->roles;
            

            // İstenilen değerleri bir diziye ekle
            $filteredData[] = [
                'name' => $userName,
                'user_image' => $userImage,
                'comment' => $comment->comment,
                'comment_created_at' => $comment->created_at,
                'user_role' => $userRole,
            ];
        }

      
        return Response::json(['comments' => $filteredData]);
        return response([
            $comments
        ]);
    }

    public function StoreComments(Request $request,$token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_guide = User::whereHas("roles", function($q) {
            $q->where("name", "guide");})->find($id);
        
        if(!$requested_guide) {
            return response([
                'error_status' => '1',
                'message' => 'This guide is undifinded.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $rules = [
            'comment' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }

        $guide= User::where('user_id', $id)->first();
        if($guide) {
            Comments::create([
                'comment' => $request->comment,
                'guide_id' => $id,
                'user_id' => $user->user_id,
                'created_at' => Carbon::now(),
            ]);
        }

        $comments = Comments::where('guide_id', '=', $id)->orderBy('id', 'desc')->get();
        return response([
            'message' => 'Your comment uploaded successfully',
        ]);
    }

    public function DeleteComments($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_comments = Comments::find($id);
        if(!$requested_comments) {
            return response([
                'error_status' => '1',
                'message' => 'This comment is undefinded.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $req_comments = Comments::findOrFail($id)->delete();

        $comments = Comments::where('guide_id', '=', $id)->orderBy('id', 'desc')->get();
        return response([
            'error_status' => '0',
            'message' => 'Your comment deleted successfully.'
        ]);
    }
}
