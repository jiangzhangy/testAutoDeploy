<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('components.app');
});
// 登录页面
Route::get('/login', [\App\Http\Controllers\Authorization::class, 'login'])->name('login');
// 登出
Route::get('/logout', [\App\Http\Controllers\Authorization::class, 'logout'])->name('logout');
// 后台路由组
Route::controller(\App\Http\Controllers\Dashboard::class)->middleware('logined')->group(function(){
    // 个人后台页面
    Route::get('dashboard','index')->name('dashboard');
    // 个人中心
    Route::get('dashboard/account','account')->name('dashboard-account');
    // 我的产品
    Route::get('dashboard/products','products')->name('dashboard-products');
    // 帮助中心
    Route::get('/dashboard/help','help')->name('dashboard-help');
});