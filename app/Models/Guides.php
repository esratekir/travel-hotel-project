<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Comments;
class Guides extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Country():BelongsTo
    {
        return $this->belongsTo(Destination::class,'country','id');
    }

    public function GuideLanguage():HasMany
    {
        return $this->hasMany(GuideLanguage::class,'guide_id', 'id');
    }

    public function Language()
    {
        return $this->belongsToMany(Languages::class, 'guide_languages','guide_id', 'language_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comments::class,'guide_id', 'id')->whereNull('comment_id');
    }

    public function citi():BelongsTo
    {
        return $this->belongsTo(City::class,'city','id');
    }

}
