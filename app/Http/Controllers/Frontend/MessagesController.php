<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Complaint;
use App\Models\DeletedMessage;

class MessagesController extends Controller
{
    public function getMessageCountsBySender() {
        $recipientId = Auth::user()->user_id;

        $messageCounts = Message::select('sender_id', DB::raw('count(*) as count'))
            ->where('recipient_id', $recipientId)
            ->where('is_read', false)
            ->groupBy('sender_id')
            ->get();
        
        return $messageCounts;
    }

    public function MyMessages() {
        
        $recipientId = Auth::user()->user_id;
        $receivedMessages = Message::where('recipient_id', $recipientId)->with('sender')->select('sender_id')
            ->distinct()
            ->get();
        
        $messageCountsBySender = $this->getMessageCountsBySender();
        //dd($receivedMessages);
        
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
        $senders = User::whereIn('user_id', $userIds)->latest()->get();
        //dd($senders);
       
        
        $sender_first = User::whereIn('user_id', $userIds)->first();
        //dd($sender_first);

        if(isset($sender_first)){
            $send_id = Auth()->user()->user_id;
            $first_id = $sender_first->user_id;
       
            $messages = Message::where(function($query) use ($send_id, $first_id) {
                $query->where('sender_id', $send_id)
                    ->where('recipient_id', $first_id);
            })->orWhere(function($query) use ($send_id, $first_id) {
                $query->where('sender_id', $first_id)
                    ->where('recipient_id', $send_id);
            })->orderBy('created_at', 'asc')->get();
           
            foreach ($messages as $message) {
                if ($message->recipient_id === $send_id && !$message->is_read) {
                    $message->is_read = true;
                    $message->save();
                }
            }
            return view('frontend.pages.my_messages', compact('senders', 'messageCountsBySender',  'sender_first', 'messages'));
        }
        else
        {
            return view('frontend.pages.my_messages', compact('senders', 'messageCountsBySender', 'sender_first'));
        }            
    }

    public function MyMessagesDetails($id) {
        $sender = User::findOrFail($id);
        
        $send_id = Auth()->user()->user_id;
        $recipientId = Auth::user()->user_id;
        $receivedMessages = Message::where('recipient_id', $recipientId)->with('sender')->select('sender_id')
            ->distinct()
            ->get();
        $messageCountsBySender = $this->getMessageCountsBySender();
        // Gönderenlerin ID'lerini alıyoruz

        $sendMessages = Message::where('sender_id', $recipientId)->with('receiver')->select('recipient_id')
            ->distinct()
            ->get();
        
        // Gönderenlerin ID'lerini alıyoruz
        $senderIds = $receivedMessages->pluck('sender_id')->toArray();
        $receivedIds = $sendMessages->pluck('recipient_id')->toArray();
        
        // ID'leri kullanarak gönderen kullanıcıları tekrarlamadan alıyoruz
        $userIds = array_merge($senderIds, $receivedIds);
        $userIds = array_unique($userIds);

        // Bu kullanıcıları almak için bir SQL sorgusu oluşturun
        $senders = User::whereIn('user_id', $userIds)->latest()->get();
       

        // $senders = User::whereIn('user_id', $senderIds)->get();
        $messages = Message::where(function($query) use ($send_id, $id) {
            $query->where('sender_id', $send_id)
                  ->where('recipient_id', $id);
        })->orWhere(function($query) use ($send_id, $id) {
            $query->where('sender_id', $id)
                  ->where('recipient_id', $send_id);
        })->orderBy('created_at', 'asc')->get();
       
        foreach ($messages as $message) {
            if ($message->recipient_id === $send_id && !$message->is_read) {
                $message->is_read = true;
                $message->save();
            }
        }
        
        return view('frontend.pages.my_messages', compact('sender', 'messages', 'senders', 'messageCountsBySender'));    
    }

   
    public function SendMessage(Request $request) {
       
        $request->validate([
            'content' => 'required',
        ]);     
        $message = Message::create([
            'sender_id' => Auth::user()->user_id,
            'recipient_id' => $request->recipient_id,
            'content' => $request->content,
            'is_read' => $request->is_read,
            'created_at' => Carbon::now(),
                 
        ]);
     
        return response()->json($message);
 
    }
 
    public function checkNewMessages(Request $request){
        $recipientId = Auth::user()->user_id;
        $messages = Message::where('recipient_id', $recipientId)->where('created_at', '>', now()->subSeconds(5))->get();
        return response()->json(['messages' => $messages]);
    }

    public function MessageAsRead(Request $request){
        $messageId = $request->input('messageId');

        // Mesajı veritabanında bul ve is_read değerini güncelle
        $message = Message::find($messageId);
        if ($message) {
            $message->is_read = true;
            $message->save();
            return response()->json(['message' => 'Message marked as read']);
        }
    }

    public function countNewMessages(){
        if(Auth::check()) {
            $recipientId = Auth::user()->user_id;
        
            $newMessagesCount = Message::where('recipient_id', $recipientId)
                ->where('is_read', false) // Assuming you have an 'is_read' column to track read status
                ->count();

            return $newMessagesCount;
        }
        
    }

    public function ReportUser(Request $request) {
        $request->validate([
            'report_message' => 'required',
        ]);

        $report = Complaint::create([
            'user_id' => Auth::user()->user_id,
            'reported_user_id' => $request->reported_id,
            'message' => $request->report_message,
        ]);


        $notification = array(
            'message' => 'Your report created successfully.',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    public function DeleteChats($id) {
        $senderId = Auth::user()->user_id;
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

        $notification = array([
            'message' => 'Your chat cleaned successfully.',
            'alert-type' => 'success',
        ]);

        return redirect()->back()->with($notification);
    }
}
