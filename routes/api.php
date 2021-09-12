<?php

use App\Http\Controllers\Admin\IndexController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::resource('photo', 'PhotoController');
Route::prefix("index")->group(function () {
    Route::post('login', [IndexController::class, 'login']);     //登入
//    Route::get('/googleLogin', [IndexController::class, 'googleLogin']);
//    Route::get('/logout', [IndexController::class, 'logout']);
    Route::get('/auth', [IndexController::class, 'redirectToProvider']);
    Route::get('/oauth_callback', [IndexController::class, 'handleProviderCallback']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
