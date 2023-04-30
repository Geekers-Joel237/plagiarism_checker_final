<?php

namespace App\Http\Controllers\Pliagiat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.settings.settings');
    }
}
