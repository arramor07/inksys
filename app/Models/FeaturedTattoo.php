<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedTattoo extends Model
{
    use HasFactory;

    protected $fillable = ['name','image','description'];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    public function favoritedBy(){
    return $this->morphMany(Favorite::class, 'favoritable');
}
}
