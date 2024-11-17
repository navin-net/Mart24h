<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage(Request $request)
    {
        $language = $request->input('language');
        Session::put('locale', $language);
        App::setLocale($language);
        return redirect()->back();
    }
    public function switch($language)
    {
        if (in_array($language, ['en', 'km'])) {
            App::setLocale($language);
            Session::put('locale', $language);
        }

        return redirect()->back();
    }
}
