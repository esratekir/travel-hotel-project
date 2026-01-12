<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'user_id', 'user_id');
    }

    public function guide(){
        return $this->belongsTo(Guides::class, 'guide_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(Comments::class,'comment_id','id');
    }

}
