<?php

namespace App\Http\Middleware;

use App\Models\RequestApi;
use Closure;
use Illuminate\Http\Request;

class EnsureHasLogined
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('auth')){
            return redirect('login');
        }
        $client = new RequestApi();
        $res = $client->getUserInfo();
        session(['userInfo' => json_decode($res->getBody()->getContents(), true)['data']]);
        return $next($request);
    }
}
