<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turlar extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Countries():BelongsTo
    {
        return $this->belongsTo(Destination::class,'country','id');
    }
}
