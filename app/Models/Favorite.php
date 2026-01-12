<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function favoriUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function favoriGuide()
    {
        return $this->belongsTo(User::class, 'guide_id', 'user_id');
    }


}
