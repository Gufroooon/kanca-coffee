<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, $menuId)
    {
        if (! Auth::check()) {
            return response()->json(['status' => 'unauthenticated', 'message' => 'Please login to save favorite items.'], 401);
        }

        $userId = Auth::id();
        $favorite = Favorite::where('user_id', $userId)->where('menu_id', $menuId)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from favorites!']);
        } else {
            Favorite::create(['user_id' => $userId, 'menu_id' => $menuId]);
            return response()->json(['status' => 'added', 'message' => 'Added to favorites!']);
        }
    }
}
