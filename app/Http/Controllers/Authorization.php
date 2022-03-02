<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Authorization extends Controller
{
    public function login(Request $request)
    {
        if ($request->input('openid')) {

        }
        return view('pages.auth.login');
    }
}
