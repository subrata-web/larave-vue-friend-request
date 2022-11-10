<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\FriendController;
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

Route::group(['prefix' => 'v1'], function () {

    Route::controller(AuthController::class)->group(function () {
        Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
            Route::post('/register', 'signup')->name('register');
            Route::post('/login', 'signin')->name('signin');
        });
    });
    
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/me', function () {
            return auth()->user();
        });
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

        Route::controller(FriendController::class)->group(function () {
            Route::group(['prefix' => 'friends', 'as' => 'friends.'], function () {
                Route::get('/', 'showFriends')->name('index');
                Route::post('/', 'store')->name('store');
                Route::post('/remove', 'removeFriend')->name('remove');
                Route::post('/request', 'requestAC')->name('request');
            });
        });
    });
});
