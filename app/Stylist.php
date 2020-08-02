<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stylist extends Model
{
    protected $table = 'stylists';

    protected $fillable = [
        'user_id',
        'profile_photo_url',
        'job_title',
        'introduction',
        'service'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function treatments() {
        return $this->hasMany(Treatment::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

}
