<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShopApiController;

Route::get('/shops/{shop}', [ShopApiController::class, 'show']);
Route::get('/shops/{shop}/featured-tattoos', [ShopApiController::class, 'featuredTattoos']);