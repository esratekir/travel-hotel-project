<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Languages extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function guide_langu()
    {
        return $this->hasMany(GuideLanguage::class,'language_id','id');
    }
}
