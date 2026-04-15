<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'email',
    'phone',
    'home_address',     // ← add this
    'appointment_date',
    'appointment_time',
    'tattoo_prompt',
    'additional_message',
    'ai_image_url',
    'reference_image_url',
    'status',
    'shop_id',
];


protected $casts = [
    'appointment_date'    => 'date',
    'downpayment_amount'  => 'decimal:2',
    'final_payment_amount'=> 'decimal:2',
];

public function shop()
{
    return $this->belongsTo(Shop::class);
}



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
