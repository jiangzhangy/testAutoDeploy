<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function index()
    {
        $auth = session('auth');
        if (!$auth){
            return redirect('login');
        }
        return view('pages.dashboard.dashboard');
    }

    public function account()
    {
        $auth = session('auth');
        if (!$auth){
            return redirect('login');
        }
        return view('pages.dashboard.account');
    }

    public function help()
    {
        $auth = session('auth');
        if (!$auth){
            return redirect('login');
        }
        return view('pages.dashboard.help');
    }

    public function products()
    {
        $auth = session('auth');
        if (!$auth){
            return redirect('login');
        }
        return view('pages.dashboard.products');
    }
}
