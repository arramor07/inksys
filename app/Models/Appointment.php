<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function shop()
{
    return $this->belongsTo(Shop::class);
}
    //
}
