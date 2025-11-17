<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function change($locale)
    {
        if (! in_array($locale, ['en', 'fa'])) {
            $locale = 'en';
        }

        Session::put('locale', $locale);

        return redirect()->back();
    }

}
