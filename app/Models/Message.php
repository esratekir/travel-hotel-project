<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];


    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id','user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'recipient_id', 'user_id');
    }   

    public function User()
    {
        return $this->belongsTo(User::class, 'recipient_id', 'sender_id', 'user_id');
    }
}
