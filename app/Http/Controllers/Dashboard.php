<?php

namespace App\Http\Controllers;

class Dashboard extends Controller
{

    public function index()
    {
        return view('pages.dashboard.help');
    }

    public function account()
    {
        return view('pages.dashboard.account');
    }

    public function help()
    {
        return view('pages.dashboard.help');
    }

    public function products()
    {
        return view('pages.dashboard.products');
    }
}
