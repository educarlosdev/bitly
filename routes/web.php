<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{link:slug}', function (\App\Models\Link $link) {
    $hit = new \App\Models\Hit();
    $hit->ip = request()->ip();
    $hit->user_agent = request()->userAgent();
    $link->hits()->save($hit);

    $link->increment('views');

    return redirect()->to($link->url);
});
