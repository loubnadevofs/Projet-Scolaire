<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class LocaleController extends Controller
{
    public function switchLocale($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
