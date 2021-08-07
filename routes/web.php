<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeccController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\chart\ChartController;
use App\Http\Controllers\finance\CodeController;
use App\Http\Controllers\finance\FactController;
use App\Http\Controllers\finance\ReportController;
use App\Http\Controllers\ChartCollectionController;
use App\Http\Controllers\finance\EtlIncomeController;
use App\Http\Controllers\finance\EtlBalanceController;
use App\Http\Controllers\finance\DataWarehouseController;
use App\Http\Controllers\finance\DateDimensionController;

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

// Targets
Route::prefix('/target')->group(function(){
    Route::middleware('auth')->get('/list/{id}', [TargetController::class, 'list']);
    Route::middleware('auth')->post('/store', [TargetController::class, 'store']);
    Route::middleware('auth')->post('/show', [TargetController::class, 'show']);
    Route::middleware('auth')->put('/update', [TargetController::class, 'update']);
    Route::middleware('auth')->put('/acquire', [TargetController::class, 'acquire']);
    Route::middleware('auth')->delete('/destroy/{company}', [TargetController::class, 'destroy']);
});

//Uploads
Route::prefix('/upload')->group(function(){
    Route::middleware('auth')->post('/avatar', [UploadController::class, 'avatar']);
    Route::middleware('auth')->post('/companylogo', [UploadController::class, 'companylogo']);
    Route::middleware('auth')->post('/contact', [UploadController::class, 'contact']);
    Route::middleware('auth')->post('/pecc', [UploadController::class, 'pecc']);
});

// Codes
Route::prefix('/code')->group(function(){
    Route::get('/all', [CodeController::class, 'index']);
    Route::post('/store', [CodeController::class, 'store']);
    Route::post('/data', [CodeController::class, 'data']);
    Route::put('/update', [CodeController::class, 'update']);
    Route::delete('/destroy/{report}', [CodeController::class, 'destroy']);
});

// ETL
Route::prefix('/etl')->group(function(){
    Route::post('/extract/income', [EtlIncomeController::class, 'extract']);
    Route::post('/extract/balance', [EtlBalanceController::class, 'extract']);
});

// DW
Route::prefix('/dw')->group(function(){
    Route::post('/report', [DataWarehouseController::class, 'report']);
});


// Reports
Route::prefix('/report')->group(function(){
    Route::post('/all', [ReportController::class, 'index']);
    Route::post('/show', [ReportController::class, 'show']);
    Route::post('/store', [ReportController::class, 'store']);
    Route::put('/update', [ReportController::class, 'update']);
    Route::delete('/destroy/{report}', [ReportController::class, 'destroy']);
});

// Date
Route::prefix('/date')->group(function(){
    Route::get('/all', [DateDimensionController::class, 'index']);
    Route::post('/store', [DateDimensionController::class, 'store']);
    Route::post('/show', [DateDimensionController::class, 'show']);
    Route::put('/update', [DateDimensionController::class, 'update']);
    Route::delete('/destroy/{report}', [DateDimensionController::class, 'destroy']);
});

// Fact
Route::prefix('/fact')->group(function(){
    Route::post('/all', [FactController::class, 'index']);
    Route::post('/records', [FactController::class, 'records']);
    Route::post('/amount', [FactController::class, 'fact_amount']);
    Route::post('/store', [FactController::class, 'store']);
    Route::post('/show', [FactController::class, 'show']);
    Route::put('/update', [FactController::class, 'update']);
    Route::post('/destroy/bulk', [FactController::class, 'destroy_bulk']);
    Route::delete('/destroy/{id}', [FactController::class, 'destroy']);
});

