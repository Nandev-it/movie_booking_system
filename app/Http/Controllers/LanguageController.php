<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function setLanguage(Request $request)
    {
        $locale = $request->input('locale');
        $supported = ['en', 'kh', 'kr', 'jp'];

        if (!in_array($locale, $supported)) {
            return response()->json(['error' => 'Unsupported locale'], 422);
        }

        session(['locale'] = $locale);
        App::setLocale($locale);

        // Return the new translations so Alpine can update reactively
        return response()->json([
            'success'      => true,
            'locale'       => $locale,
            'translations' => trans('messages'), // returns the full array
        ]);
    }
}
