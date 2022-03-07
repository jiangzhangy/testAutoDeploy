<?php

namespace App\Http\Controllers;

use App\Models\RequestApi;
use Illuminate\Http\Request;

class Authorization extends Controller
{
    public function login(Request $request)
    {
        if (session('auth')){
            return redirect('dashboard');
        }
        if ($request->input('openid')) {
            $client = new RequestApi();
            $res = $client->getUserByOpenid($request->input('openid'));
            if ($res !== false){
                $resArr = json_decode($res->getBody()->getContents(), true);
                if ($resArr['status'] === 16001){
                    return view('pages.auth.login', [
                        'linkedAccount' => $request->input('openid')
                    ]);
                }elseif ($resArr['status'] === 0){
                    session(['auth' => $resArr['data']]);
                    return redirect('dashboard');
                }
            }
        }
        return view('pages.auth.login');
    }

    public function logout()
    {
        session()->invalidate();
        return redirect('login');
    }
}
