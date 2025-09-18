<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language
     */
    public function switch(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|in:en,ar',
        ]);

        $language = $request->input('locale');

        // Set the application locale
        App::setLocale($language);

        // Store in session for persistence
        Session::put('locale', $language);

        // Return back to the previous page with success
        return back()->with('success', 'Language switched successfully');
    }

    /**
     * Get current language
     */
    public function current()
    {
        return response()->json([
            'language' => App::getLocale(),
        ]);
    }
}
