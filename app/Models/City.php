<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Destination::class, 'country_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'city');
    }
}
