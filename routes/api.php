<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'common'], function () {
    Route::post('login', 'Auth\LoginController@login')->name('login');
    Route::post('register', 'Auth\RegisterController@create')->name('register');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('profile', 'Auth\UserController@index')->name('getProfile');
        Route::put('profile', 'Auth\UserController@update')->name('updateProfile');
        Route::put('change-password', 'Auth\ChangePasswordController@changePassword')->name('changePassword');
    });
});
