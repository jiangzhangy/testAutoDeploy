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
// 个人后台页面
Route::get('/dashboard', [\App\Http\Controllers\Dashboard::class, 'index'])->name('dashboard');
// 个人中心
Route::get('/dashboard/account', [\App\Http\Controllers\Dashboard::class, 'account'])->name('dashboard-account');
// 我的产品
Route::get('/dashboard/products', [\App\Http\Controllers\Dashboard::class, 'products'])->name('dashboard-products');
// 帮助中心
Route::get('/dashboard/help', [\App\Http\Controllers\Dashboard::class, 'help'])->name('dashboard-help');