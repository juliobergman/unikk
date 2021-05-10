<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\chart\ChartController;
use App\Http\Controllers\ChartCollectionController;
use App\Http\Controllers\MembershipController;

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
Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/test', [TestController::class, 'index']);



// Users
Route::prefix('/user')->group(function(){
    Route::middleware('auth')->post('/new', [UserController::class, 'store']);
    Route::middleware('auth')->get('/all', [UserController::class, 'index']);
    Route::middleware('auth')->get('/current', [UserController::class, 'currentUser']);
    Route::middleware('auth')->put('/', [UserController::class, 'update']);
    Route::middleware('auth')->delete('/{id}', [UserController::class, 'destroy']);
    Route::middleware('guest')->get('/create-password/{token}/{email}', [UserController::class, 'create_password'])->name('password.create');
    Route::middleware('guest')->put('/create-new-password', [UserController::class, 'create_password_new']);
});




// Charts
Route::prefix('/chart')->group(function(){
    Route::middleware('auth')->get('/collections/{company}', [ChartCollectionController::class, 'collections']);
    Route::middleware('auth')->get('/collection/{id}', [ChartCollectionController::class, 'collection']);

    Route::middleware('auth')->get('/all', [ChartController::class, 'index']);
    Route::middleware('auth')->post('/store', [ChartController::class, 'store']);
    Route::middleware('auth')->get('/{chart}', [ChartController::class, 'show']);
    Route::middleware('auth')->put('/{chart}', [ChartController::class, 'update']);
    Route::middleware('auth')->delete('/{chart}', [ChartController::class, 'destroy']);
});

// Company
Route::middleware('auth')->prefix('/company')->group(function(){
    Route::get('/all', [CompanyController::class, 'index']);
    Route::get('/{id}', [CompanyController::class, 'show']);
});

// Memberships
Route::middleware('auth')->prefix('/membership')->group(function(){
    Route::get('/current', [MembershipController::class, 'current']);
    Route::get('/companies', [MembershipController::class, 'companies']);
    Route::get('/users/{company}', [MembershipController::class, 'users']);
    Route::put('/default/{membership}', [MembershipController::class, 'set_default']);
});






