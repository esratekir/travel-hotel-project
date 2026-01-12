<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function trip(){
        return $this->belongsTo(MyTrip::class,'id', 'destination');
    }

    public function cities()
    {
        return $this->hasMany(City::class,'id', 'country_id');
    }
}
