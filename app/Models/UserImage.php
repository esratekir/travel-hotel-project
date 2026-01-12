<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function guides()
    {
        return $this->belongsTo(User::class, 'userid', 'user_id');

    }
}
