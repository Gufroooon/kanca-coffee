<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::orderBy('position', 'asc')->get();
        $bestsellers = Menu::with('category')->where('is_bestseller', true)->where('is_available', true)->take(6)->get();
        $upcomingEvents = Event::where('date', '>=', now()->toDateString())->orderBy('date', 'asc')->take(3)->get();
        $testimonials = Testimonial::where('is_featured', true)->take(6)->get();
        $galleries = Gallery::take(8)->get();
        $stats = [
            'menus' => Menu::where('is_available', true)->count(),
            'events' => Event::where('date', '>=', now()->toDateString())->count(),
            'categories' => $categories->count(),
            'testimonials' => $testimonials->count(),
        ];
        $announcement = Setting::getByKey('announcement_banner', 'Welcome to Kanca Coffee! Teman yang kamu cari ada di seberang meja.');

        return view('home', compact('categories', 'bestsellers', 'upcomingEvents', 'testimonials', 'galleries', 'stats', 'announcement'));
    }
}
