<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\chart\ChartController;

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

Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Users
Route::prefix('/user')->group(function(){
    Route::middleware('auth')->get('/all', [UserController::class, 'index']);
    Route::middleware('auth')->get('/current', [UserController::class, 'currentUser']);
});

// Charts
Route::middleware('auth')->prefix('/chart')->group(function(){
    Route::get('/all', [ChartController::class, 'index']);
    Route::post('/store', [ChartController::class, 'store']);
    Route::get('/{chart}', [ChartController::class, 'show']);
    Route::put('/{chart}', [ChartController::class, 'update']);
    Route::delete('/{chart}', [ChartController::class, 'destroy']);
});






