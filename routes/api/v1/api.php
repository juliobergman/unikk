<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\user\UserController;
use App\Http\Controllers\api\v1\chart\ChartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Users
Route::prefix('/user')->group(function(){
    Route::post('/login', [LoginController::class, 'login']);
    Route::middleware('auth:api')->get('/all', [UserController::class, 'index']);
    Route::middleware('auth:api')->get('/current', [UserController::class, 'currentUser']);
});

// Charts
Route::prefix('/chart')->group(function(){
    Route::middleware('auth:api')->get('/all', [ChartController::class, 'index']);
    Route::middleware('auth:api')->post('/store', [ChartController::class, 'store']);
    Route::middleware('auth:api')->get('/{chart}', [ChartController::class, 'show']);
    Route::middleware('auth:api')->put('/{chart}', [ChartController::class, 'update']);
    Route::middleware('auth:api')->delete('/{chart}', [ChartController::class, 'destroy']);
});
