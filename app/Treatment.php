<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table = 'treatments';
  
    public function stylist() {
        return $this->belongsTo(Stylist::class);
    }


    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
