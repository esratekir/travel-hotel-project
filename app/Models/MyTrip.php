<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class MyTrip extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Destinati():BelongsTo
    {
        return $this->belongsTo(Destination::class,'destination','id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'guide_id','user_id');
    }

    public function citi():BelongsTo
    {
        return $this->belongsTo(City::class,'destination','id');
    }


}
