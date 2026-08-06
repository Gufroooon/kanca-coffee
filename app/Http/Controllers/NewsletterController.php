<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        NewsletterSubscriber::firstOrCreate(['email' => $validated['email']], ['subscribed_at' => now()]);

        return back()->with('success', 'Thank you for subscribing to Kanca Coffee newsletter!');
    }
}
