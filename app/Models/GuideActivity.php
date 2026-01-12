<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideActivity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guide()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function activiti()
    {
        return $this->belongsTo(Activity::class,'activity_id','id');
    }
}
