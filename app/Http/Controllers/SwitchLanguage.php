<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SwitchLanguage extends Controller
{
    public function setLocale($lang)
    {
        session()->put('lang', $lang);

        return redirect()->back();
    }
}
