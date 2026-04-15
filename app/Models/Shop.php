<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'cover_image',
        'is_approved',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function portfolioItems()
    {
        return $this->hasMany(PortfolioItem::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function featuredTattoos()
{
    return $this->hasMany(FeaturedTattoo::class);
}

public function favoritedBy(){
    return $this->morphMany(Favorite::class, 'favoritable');
}

}
