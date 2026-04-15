<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',   // e.g., 'admin', 'client'
        'shop_id', // add this if user belongs to a shop
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationships
     */

    // If user can book multiple appointments
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // If user is a shop admin or belongs to a shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function favorites(){
    return $this->morphToMany(Favoritable::class, 'favoritable', 'favorites');
}
}
