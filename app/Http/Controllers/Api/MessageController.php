<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DeletedMessage;
use Illuminate\Support\Facades\Response;


class MessageController extends Controller
{
    public function MyMessages($token) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $recipientId = $user->user_id;
        $receivedMessages = Message::where('recipient_id', $recipientId)->with('sender')->select('sender_id')
            ->distinct()
            ->get();
        
        
        
        $sendMessages = Message::where('sender_id', $recipientId)->with('receiver')->select('recipient_id')
            ->distinct()
            ->get();
        
        // Gönderenlerin ID'lerini alıyoruz
        $senderIds = $receivedMessages->pluck('sender_id')->toArray(); // 270,509
        $receivedIds = $sendMessages->pluck('recipient_id')->toArray(); //270,504,509,179
        
        // ID'leri kullanarak gönderen kullanıcıları tekrarlamadan alıyoruz
        $userIds = array_merge($senderIds, $receivedIds);
        $userIds = array_unique($userIds);

        // Bu kullanıcıları almak için bir SQL sorgusu oluşturdum
        $senders = User::whereIn('user_id', $userIds)->select('user_id', 'name','image', 'last_seen')->with('roles')->latest()->get();
        //dd($senders);
        $messageCountsBySender = Message::where('recipient_id', $recipientId)
            ->where('is_read', false) 
            ->count();
    
        
        $sender_first = User::whereIn('user_id', $userIds)->select('user_id', 'name', 'image', 'last_seen')->first();
        //dd($sender_first);

        if (isset($sender_first)) {
            $send_id = $user->user_id;
            $first_id = $sender_first->user_id;
    
            $messages = Message::where(function($query) use ($send_id, $first_id) {
                $query->where('sender_id', $send_id)
                    ->where('recipient_id', $first_id);
            })->orWhere(function($query) use ($send_id, $first_id) {
                $query->where('sender_id', $first_id)
                    ->where('recipient_id', $send_id);
            })->orderBy('created_at', 'asc')->get();
    
            // Son mesajları almak için bir dizi oluştur
            $lastMessages = [];
            foreach ($userIds as $userId) {
                $lastMessage = Message::where(function($query) use ($send_id, $userId) {
                    $query->where('sender_id', $send_id)
                        ->where('recipient_id', $userId);
                })->orWhere(function($query) use ($send_id, $userId) {
                    $query->where('sender_id', $userId)
                        ->where('recipient_id', $send_id);
                })->orderBy('created_at', 'desc')->first();
    
                if ($lastMessage) {
                    $lastMessages[] = [
                        'user_id' => $userId,
                        'last_message' => $lastMessage->content,
                    ];
                }
            }
    
            foreach ($messages as $message) {
                if ($message->recipient_id === $send_id && !$message->is_read) {
                    $message->is_read = true;
                    $message->save();
                }
            }
            
            

            return response([
                'people_messaged' => $senders,
                'last_messages' => $lastMessages,
                'unread_messages' => $messageCountsBySender
            ]);
        }
        else
        {
            if(count($senders) <= 0) {
                return response([
                    'message' => 'No conversation with this user'
                ]);
            }
        }
         


    }

    public function ReportUser(Request $request, $token, $id)  {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_user = User::find($id);
        if(!$requested_user) {
            return response([
                'error_status' => '1',
                'message' => 'User not found.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now()) ) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please log in again.'
            ]);
        }

        $rules = [
            'report_message' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'error_status' => 1]);
        }

        $report = Complaint::create([
            'user_id' => $user->user_id,
            'reported_user_id' => $id,
            'message' => $request->report_message,
        ]);

        return response([
            $report
        ]);
    }

    public function SendMessage(Request $request, $token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_user = User::findOrFail($id);
        if(!$requested_user) {
            return response([
                'error_status' => '1',
                'message' => 'User not found'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => '1',
                'message' => 'This token has expired. Please login again!'
            ]);
        }

        $rules = [
            'content' => 'required|min:10',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response(['message' => $validator->errors(), 'error_status' => 1]);
        }

        $message = Message::create([
            'sender_id' => $user->user_id,
            'recipient_id' => $id,
            'content' => $request->content,
            'is_read' => false,
            'created_at' => Carbon::now(),
        ]);

        return response([
            'message' => 'Your message send successfully'
        ]);
    }

    public function MessageDetails($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => '1',
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_user = User::findOrFail($id);
        if(!$requested_user) {
            return response([
                'error_status' => 1,
                'message' => 'User not found'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again.'
            ]);
        }
        
        $send_id = $user->user_id;
        $recipientId = $user->user_id;
   
        // $messageCountsBySender = Message::where('sender_id', $recipientId)
        //     ->where('is_read', false) 
        //     ->count();
    
        // $senders = User::whereIn('user_id', $senderIds)->get();
        $messages = Message::where(function($query) use ($send_id, $id) {
            $query->where('sender_id', $send_id)
                  ->where('recipient_id', $id);
        })->orWhere(function($query) use ($send_id, $id) {
            $query->where('sender_id', $id)
                  ->where('recipient_id', $send_id);
        })->with('sender','receiver')->orderBy('created_at', 'desc')->get();
        
        foreach ($messages as $message) {
            if ($message->recipient_id === $send_id && !$message->is_read) {
                $message->is_read = true;
                $message->save();
            }
        }
        if(count($messages) <= 0) {
            return response([
                'message' => 'No conversation with this user'
            ]);
        }

        $filteredData = [];

        foreach ($messages as $message) {
            
            $senderId = $message->sender->user_id;
            $senderName = $message->sender->name;
            $senderImage = $message->sender->image;
            $senderMessage = $message->content;
            $message_createdat = $message->created_at;
            $recipientId = $message->receiver->user_id;
            $recipientName = $message->receiver->name;
            $recipientImage = $message->receiver->image;
            $recipientRole = $message->receiver->roles;
            
            $filteredData[] = [
                'sender_id' => $senderId,
                'sender_name' => $senderName,
                'sender_image' => $senderImage,
                'message' => $senderMessage,
                'message_createdat' => $message_createdat,
                'recipient_id' => $recipientId,
                'recipient_name' => $recipientName,
                'recipient_image' => $recipientImage,
                'recipient_role' => $recipientRole,
            ];
            
        }

        return Response::json(['messageDetails' => $filteredData]);
    }

    public function MessageasRead($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => 1,
                'message' => 'Token is invalid.'
            ]);
        }

        $message = Message::findOrFail($id);
        if(!$message) {
            return response([
                'error_status' => 1,
                'message' => 'Message not found.'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again!'
            ]);
        }
        
        if ($message) {
            $message->is_read = true;
            $message->save();
            return response()->json(['message' => 'Message marked as read']);
        }
    }

    public function DeleteChat($token, $id) {
        $user = User::where('token', $token)->first();
        if(!$user) {
            return response([
                'error_status' => 1,
                'message' => 'Token is invalid.'
            ]);
        }

        $requested_chat = User::findOrFail($id);
        if(!$requested_chat) {
            return response([
                'error_status' => 1,
                'message' => 'User not found!'
            ]);
        }

        if($user->token_expired_at <= Carbon::parse(Carbon::now())) {
            return response([
                'error_status' => 1,
                'message' => 'This token has expired. Please login again!'
            ]);
        }

        $senderId = $user->user_id;
        $messagesToDelete = Message::where(function($query) use ($senderId, $id) {
            $query->where('sender_id', $senderId)
                  ->where('recipient_id', $id);
        })->orWhere(function($query) use ($senderId, $id) {
            $query->where('sender_id', $id)
                  ->where('recipient_id', $senderId);
        })->get(); // Mesajları al, ancak henüz silme işlemi yapma
        
        // Silinen mesajları DeletedMessage tablosuna ekle
        foreach ($messagesToDelete as $message) {
            DeletedMessage::create([
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'recipient_id' => $message->recipient_id,
                'content' => $message->content, // Message modelindeki content sütunu
            ]);
        }
        
        // Şimdi mesajları sil
        Message::whereIn('id', $messagesToDelete->pluck('id'))->delete();

        return response([
            'message' => 'Chat deleted successfully.'
        ]);
    }
}
