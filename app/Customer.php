<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable  = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
