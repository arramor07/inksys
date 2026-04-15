<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class HomeController extends Controller
{
    public function index(Request $request){
    $query = $request->input('search');
    $shops = Shop::where('status','approved')
                 ->when($query, function($q) use ($query){
                     $q->where('name','like',"%$query%");
                 })->get();
    return view('welcome', compact('shops'));
}
}