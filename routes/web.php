<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\api\v1\chart\ChartController;

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
    return view('welcome');
});

Auth::routes();
Route::post('/login', [LoginController::class, 'login']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Charts
Route::prefix('/chart')->group(function(){
    Route::get('/all', [ChartController::class, 'index']);
    Route::get('/{id}', [ChartController::class, 'show']);
    Route::post('/store', [ChartController::class, 'store']);
    Route::delete('/{chart}', [ChartController::class, 'destroy']);
});
