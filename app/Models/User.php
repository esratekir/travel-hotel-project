<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends  Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;
    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';

    protected $guarded = [];

    public function Country():BelongsTo
    {
        return $this->belongsTo(Destination::class,'country','id');
    }

    public function Citi():BelongsTo
    {
        return $this->belongsTo(City::class,'city','id');
    }

    public function GuideLanguage():HasMany
    {
        return $this->hasMany(GuideLanguage::class,'guide_id', 'user_id');
    }

    public function GuideActiviti():HasMany
    {
        return $this->hasMany(GuideActivity::class,'guide_id', 'id');
    }

    public function Language()
    {
        return $this->belongsToMany(Languages::class, 'guide_languages','guide_id', 'language_id');
    }

    public function Activit()
    {
        return $this->belongsToMany(Activity::class, 'guide_activities','guide_id', 'activity_id');
    }

    public function comments(){
        return $this->hasMany(Comments::class,'guide_id', 'user_id')->whereNull('comment_id')->latest();
    }

    public function UserImage():HasMany
    {
        return $this->hasMany(UserImage::class,'userid', 'user_id');
    }

    public function messages()
{
    return $this->hasMany(Message::class, 'id', 'user_id'); 
}

    public function talkedTo()
    {
        return $this->hasMany(Message::class,'sender_id', 'user_id');
    }

    public function relatedTo()
    {
        return $this->hasMany(Message::class,'recipient_id', 'user_id');
    }

    public function isOnline()
    {
        $lastSeen = Carbon::parse($this->last_seen);

        // Örnek olarak son 5 dakika içinde etkinse online olarak kabul ediyoruz
        return $lastSeen && $lastSeen->diffInMinutes(Carbon::now()) <= 5;
    }

    public function trips()
    {
        return $this->hasMany(MyTrip::class,'user_id', 'guide_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'id', 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
