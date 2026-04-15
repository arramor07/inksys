<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopRegistrationController extends Controller
{
    public function create()
    {
        return view('shop-register');
    }

    public function store(Request $request)
    {
        $logoPath = null;

        if($request->hasFile('logo')){
            $logoPath = $request->file('logo')->store('shops','public');
        }

        Shop::create([
            'name' => $request->shop_name,
            'owner_name' => $request->owner_name,
            'email' => $request->email,
            'description' => $request->description,
            'logo' => $logoPath,
            'status' => 'pending'
        ]);

        return redirect('/')->with('success','Registration submitted. Awaiting approval.');
    }
}