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
Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'admin']], function () {
    Route::resource('categories', 'Admin\CategoryController');
    Route::post('categories/{id}', 'Admin\CategoryController@update');
    Route::resource('words', 'Admin\WordController');
    Route::post('words/{id}', 'Admin\WordController@update');
    Route::resource('users', 'Admin\UserController');
    Route::post('users/{id}', 'Admin\UserController@update');
});
Route::group(['prefix' => 'user', 'middleware' => ['auth:api', 'user']], function () {
    Route::get('categories', 'User\CategoryController@index');
    Route::get('words', 'User\WordController@index');
    Route::post('lessons', 'User\LessonController@store');
    Route::put('lesson-results/{id}', 'User\LessonResultController@update');
    Route::get('lessons/{id}', 'User\LessonController@show');
});
