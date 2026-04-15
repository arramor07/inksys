<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'client_name',
        'rating',       // 1–5
        'content',      // feedback text
        'is_visible',   // 0 = hidden/pending, 1 = approved
        'shop_id',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function shop()
{
    return $this->belongsTo(Shop::class);
}
}