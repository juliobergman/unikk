<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\chart\ChartController;
use App\Http\Controllers\ChartCollectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PeccController;

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
// Route::post('/prelogin', [LoginController::class, 'prelogin']);

Route::get('/app', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/test', [TestController::class, 'index']);



// Users
Route::prefix('/user')->group(function(){
    Route::middleware('auth')->post('/new', [UserController::class, 'store']);
    Route::middleware('auth')->get('/all', [UserController::class, 'index']);
    Route::middleware('auth')->post('/show', [UserController::class, 'show']);
    Route::middleware('auth')->get('/current', [UserController::class, 'currentUser']);
    Route::middleware('auth')->put('/update', [UserController::class, 'update']);
    Route::middleware('auth')->put('/newpassword', [UserController::class, 'newpassword']);
    Route::middleware('auth')->delete('/{id}', [UserController::class, 'destroy']);

    Route::middleware('guest')->get('/create-password/{token}/{email}', [UserController::class, 'create_password'])->name('password.create');
    Route::middleware('guest')->put('/create-new-password', [UserController::class, 'create_password_new']);
});




// Charts
Route::prefix('/chart')->group(function(){
    Route::middleware('auth')->get('/collections/{company}', [ChartCollectionController::class, 'collections']);
    Route::middleware('auth')->get('/collection/{id}', [ChartCollectionController::class, 'collection']);
    Route::middleware('auth')->post('/collection/store', [ChartCollectionController::class, 'store']);

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
    Route::post('/store', [CompanyController::class, 'store']);
    Route::put('/{company}', [CompanyController::class, 'update']);
});

// Memberships
Route::prefix('/membership')->group(function(){
    Route::middleware('auth')->get('/current', [MembershipController::class, 'current']);
    Route::middleware('auth')->get('/companies', [MembershipController::class, 'companies']);
    Route::middleware('auth')->get('/users/{company}', [MembershipController::class, 'users']);
    Route::middleware('auth')->get('/notusers/{company}', [MembershipController::class, 'notusers']);
    Route::middleware('auth')->put('/default/{membership}', [MembershipController::class, 'set_default']);
    Route::middleware('auth')->post('/store', [MembershipController::class, 'store']);
    Route::middleware('auth')->put('/', [MembershipController::class, 'update']);
    Route::middleware('auth')->delete('/{id}', [MembershipController::class, 'destroy']);
});

// Contacts
Route::prefix('/contact')->group(function(){
    Route::middleware('auth')->get('/list', [ContactController::class, 'list']);
    Route::middleware('auth')->post('/store', [ContactController::class, 'store']);
    Route::middleware('auth')->post('/show', [ContactController::class, 'show']);
    Route::middleware('auth')->put('/update', [ContactController::class, 'update']);
    Route::middleware('auth')->delete('/destroy/{contact}', [ContactController::class, 'destroy']);
});

// Peccs
Route::prefix('/pecc')->group(function(){
    Route::middleware('auth')->get('/list', [PeccController::class, 'list']);
    Route::middleware('auth')->post('/store', [PeccController::class, 'store']);
    Route::middleware('auth')->post('/show', [PeccController::class, 'show']);
    Route::middleware('auth')->put('/update', [PeccController::class, 'update']);
    Route::middleware('auth')->delete('/destroy/{pecc}', [PeccController::class, 'destroy']);
});

//Uploads
Route::prefix('/upload')->group(function(){
    Route::middleware('auth')->post('/avatar', [UploadController::class, 'avatar']);
    Route::middleware('auth')->post('/companylogo', [UploadController::class, 'companylogo']);
    Route::middleware('auth')->post('/contact', [UploadController::class, 'contact']);
});



