<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','user_id');
    }

    public function reported_user()
    {
        return $this->belongsTo(User::class, 'reported_user_id', 'user_id');
    }
}
