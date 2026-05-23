<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, ['en', 'fr', 'id'])) {
            // Set locale untuk request saat ini
            App::setLocale($locale);
            
            // Simpan ke session
            Session::put('locale', $locale);
            
            // Simpan session secara eksplisit
            Session::save();
            
            // Redirect dengan cookie yang langsung terset
            return redirect()->back()->withCookie(
                cookie('locale', $locale, 60 * 24 * 30) // 30 hari
            );
        }
        
        return redirect()->back();
    }
}
