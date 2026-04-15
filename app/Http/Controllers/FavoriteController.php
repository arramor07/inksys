<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;

class FavoriteController extends Controller
{
    public function toggle(Request $request){
    $user = auth()->user();
    $model = $request->type === 'shop' ? Shop::find($request->id) : FeaturedTattoo::find($request->id);

    if($user->favorites()->where('favoritable_id',$model->id)->exists()){
        $user->favorites()->detach($model);
        return response()->json(['message'=>'Removed from favorites']);
    }

    $user->favorites()->attach($model);
    return response()->json(['message'=>'Added to favorites']);
}
}
