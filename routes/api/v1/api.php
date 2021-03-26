<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\LoginController;
use App\Http\Controllers\api\v1\user\UserController;

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
    // Route::post('/login', 'api\v1\LoginController@login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::middleware('auth:api')->get('/all', [UserController::class, 'index']);
    Route::middleware('auth:api')->get('/current', [UserController::class, 'currentUser']);
});
