<?php

use App\Http\Controllers\SpaController;
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
    return redirect()->to('admin/dashboard');
});

Route::get('admin/{any}', [SpaController::class, 'index'])
    ->where('any', '.*');

Route::get('{link:slug}', [SpaController::class, 'show']);
