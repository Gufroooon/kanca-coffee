<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $team = User::whereHas('role', function ($q) {
            $q->whereIn('slug', ['admin', 'staff']);
        })->get();

        $galleries = Gallery::where('category', 'ambiance')->get();

        return view('about', compact('team', 'galleries'));
    }
}
