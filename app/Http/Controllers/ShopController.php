<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function create(){
        return view('shops.register');
    }

    public function store(Request $request){
        $data = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:shops',
            'phone'=>'nullable',
            'description'=>'nullable',
            'logo'=>'nullable|image'
        ]);

        if($request->hasFile('logo')){
            $data['logo'] = $request->file('logo')->store('logos','public');
        }

        Shop::create($data); // status defaults to 'pending'
        return redirect('/')->with('success','Registration submitted. Awaiting approval.');
    }

    public function pending(){
        $shops = Shop::where('status','pending')->get();
        return view('shops.pending', compact('shops'));
    }

    public function approve(Shop $shop){
        $shop->update(['status'=>'approved']);
        // Optionally create default shop admin
        return back()->with('success','Shop approved!');
    }
}