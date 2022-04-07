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
        // 软件跳转到网页
        if ($request->input('access_token')){
            // 存储 auth
            $authRes = $client->getAuthByToken($request->input('access_token'));
            if ($authRes){
                $authResArr = json_decode($authRes->getBody()->getContents(), true);
                if ($authResArr['status'] === 0){
                    session(['auth' => $authResArr['data']]);
                    // 跳转到个人中心
                    if ($request->input('type') === 'goaccount'){
                        return redirect()->route('dashboard-account',['type' => $request->input('type')]);
                    }
                    // 跳转到绑定序列码或者购买
                    if ($request->input('type')){
                        return redirect()->route('dashboard-products',['type' => $request->input('type')]);
                    }
                }

            }
        }
        // 已经登录
        if (session('auth')){
            if ($request->input('openid')){
                $client->boundWechatPhone($request->input('openid'), session('auth')['account']);
                return redirect()->route('dashboard-account');
            }
            return redirect()->route('dashboard-account');
        }
        return view('pages.auth.login');
    }

    public function logout()
    {
        session()->invalidate();
        return redirect('login');
    }
}
