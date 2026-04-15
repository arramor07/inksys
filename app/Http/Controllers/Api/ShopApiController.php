<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopApiController extends Controller
{
    // Return shop info and featured tattoos
    public function show(Shop $shop)
    {
        $shop->load('featuredTattoos');
        return response()->json($shop);
    }

    public function featuredTattoos(Shop $shop)
{
    $tattoos = $shop->featuredTattoos()->get(['id','name','image','description']);
    return response()->json($tattoos);
}
}