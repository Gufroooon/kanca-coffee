<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch the application locale and store it in session.
     */
    public function switch(string $locale)
    {
        if (! in_array($locale, ['id', 'en'])) {
            $locale = config('app.locale', 'id');
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
