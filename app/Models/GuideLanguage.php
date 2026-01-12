<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideLanguage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guide()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function language()
    {
        return $this->belongsTo(Languages::class,'language_id','id');
    }


}
