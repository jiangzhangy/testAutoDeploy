<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function __construct()
    {
        $auth = session('auth');
        if (!$auth){
            return redirect('login');
        }
    }

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
