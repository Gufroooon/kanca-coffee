<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $registeredEvents = EventRegistration::with('event')
            ->where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->orderBy('registered_at', 'desc')
            ->get();

        $favorites = Favorite::with('menu.category')
            ->where('user_id', $user->id)
            ->get();

        return view('user.dashboard', compact('user', 'registeredEvents', 'favorites'));
    }
}
