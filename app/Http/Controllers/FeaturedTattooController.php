<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeaturedTattoo;
use App\Models\Shop;

class FeaturedTattooController extends Controller
{
    // Show all featured tattoos for a shop (admin view)
    public function index(Shop $shop)
    {
        $tattoos = $shop->featuredTattoos;
        return view('featured_tattoos.index', compact('tattoos','shop'));
    }

    // Form to add a new tattoo
    public function create(Shop $shop)
    {
        return view('featured_tattoos.create', compact('shop'));
    }

    // Store new tattoo
    public function store(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'description' => 'nullable',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('tattoos','public');
        }

        $shop->featuredTattoos()->create($data);

        return redirect()->route('featured_tattoos.index', $shop)->with('success','Tattoo added!');
    }

    // Edit form
    public function edit(Shop $shop, FeaturedTattoo $tattoo)
    {
        return view('featured_tattoos.edit', compact('tattoo','shop'));
    }

    // Update tattoo
    public function update(Request $request, Shop $shop, FeaturedTattoo $tattoo)
    {
        $data = $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'description' => 'nullable',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('tattoos','public');
        }

        $tattoo->update($data);

        return redirect()->route('featured_tattoos.index', $shop)->with('success','Tattoo updated!');
    }

    // Delete tattoo
    public function destroy(Shop $shop, FeaturedTattoo $tattoo)
    {
        $tattoo->delete();
        return back()->with('success','Tattoo deleted!');
    }
}
