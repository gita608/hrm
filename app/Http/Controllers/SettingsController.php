<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
