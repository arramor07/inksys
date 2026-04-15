<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Tattoo;
use App\Models\Artist;
use App\Models\Review;

class ShopClientController extends Controller
{

    public function home($id)
    {
        $shop = Shop::findOrFail($id);

        $artists = Artist::where('shop_id', $id)->get();
        $featuredTattoos = Tattoo::where('shop_id', $id)
                                ->where('featured', 1)
                                ->get();

        return view('shops.home', compact('shop','artists','featuredTattoos'));
    }

    public function portfolio($id)
    {
        $shop = Shop::findOrFail($id);

        $tattoos = Tattoo::where('shop_id',$id)->get();

        return view('shops.portfolio', compact('shop','tattoos'));
    }

    public function book($id)
    {
        $shop = Shop::findOrFail($id);

        $artists = Artist::where('shop_id',$id)->get();

        return view('shops.book', compact('shop','artists'));
    }

    public function contact($id)
    {
        $shop = Shop::findOrFail($id);

        return view('shops.contact', compact('shop'));
    }

    public function reviews($id)
    {
        $shop = Shop::findOrFail($id);

        $reviews = Review::where('shop_id',$id)->get();

        return view('shops.reviews', compact('shop','reviews'));
    }

}