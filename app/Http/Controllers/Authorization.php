<?php

namespace App\Http\Controllers;

use App\Models\RequestApi;
use Illuminate\Http\Request;

class Authorization extends Controller
{
    public function login(Request $request)
    {
        if ($request->input('openid')) {
            $client = new RequestApi();
            $res = $client->getUserByOpenid($request->input('openid'));
            if ($res !== false){
                $resArr = json_decode($res->getBody()->getContents(), true);
                if ($resArr['code'] === 16001){
                    return view('pages.auth.login', [
                        'linkedAccount' => $request->input('openid')
                    ]);
                }
            }
        }
        return view('pages.auth.login');
    }
}
