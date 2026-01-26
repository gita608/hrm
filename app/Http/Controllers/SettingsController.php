<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    /**
     * Display the settings index page.
     */
    public function index()
    {
        return view('pages.settings.index');
    }
}
