<?php

namespace App\Http\Controllers;

use App\Models\RequestApi;
use Illuminate\Http\Request;

class Authorization extends Controller
{
    public function login(Request $request, RequestApi $client)
    {
        if ($request->input('openid') && !$request->input('redirect')){
            // 携带参数跳转
            return view('redirect', ['uri' => url()->full()]);
        }
        // 已经登录
        if (session('auth')){
            if ($request->input('openid')){
                $client->boundWechatPhone($request->input('openid'));
                return redirect()->route('dashboard-account');
            }
            return redirect()->route('dashboard-account');
        }
        // 微信扫码登录
        if ($request->input('openid')) {
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
